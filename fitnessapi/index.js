// Importing modules
const express = require("express");
const cookieParser = require("cookie-parser");
const { google } = require("googleapis");
const port = process.env.PORT || 3000;

// Adding the imported methods to express
const app = express();
app.use(express.json());
app.use(cookieParser());
app.use(express.static("public"));

// const CLIENT_ID =
//   "474032726598-brlecrlhbf81ssai67r9ibthgasitrad.apps.googleusercontent.com";
// const CLIENT_SECRET = "IuSAYYxc3oVRlokUbv4v1DBy";

const CLIENT_ID =
  "741475589490-i7nfrlunhs6m9t59q23bqai37ad7kfrr.apps.googleusercontent.com";
const CLIENT_SECRET = "tJbUoBP2eBwb3UxEcqi6Pz6u";

const oAuthParams = [
  CLIENT_ID,
  CLIENT_SECRET,
  // TODO make dynamic
  `http://localhost:8080/googleauth`,
];

const scope = [
  "https://www.googleapis.com/auth/fitness.heart_rate.read",
  "https://www.googleapis.com/auth/fitness.sleep.read",
  "https://www.googleapis.com/auth/fitness.activity.read",
];

// Storing codes that allow us to exchange tokens
// const authCodeList = {};
// received tokens

// {
// "admin": {
// "refresh": "",
// "authenticate": ""
// }
// }
const tokenList = {};

async function getAuthWithToken(userId, authCode) {
  // Initialize a client
  const oauth2Client = new google.auth.OAuth2(...oAuthParams);

  if (!tokenList[userId]) {
    const { tokens } = await oauth2Client.getToken(authCode);
    //passing tokens to the client
    oauth2Client.setCredentials(tokens);
    tokenList[userId] = tokens;
  } else {
    oauth2Client.setCredentials(tokenList[userId]);
  }

  //event "token" happens every hour when a token expires
  oauth2Client.on("tokens", (tokens) => {
    if (tokens.refresh_token) {
      tokenList[userId].refresh_token = tokens.refresh_token;
    }

    tokenList[userId].access_token = tokens.access_token;
  });

  return oauth2Client;
}

app.get("/google-url", (_req, res) => {
  const oauth2Client = new google.auth.OAuth2(...oAuthParams);

  const authUrl = oauth2Client.generateAuthUrl({
    access_type: "offline",
    scope,
  });

  //req.query - an object that consists of key-value pairs; get set constant user to the value of user (from the dictionary)
  // const { user } = req.query;

  // if (!user) return res.sendStatus(403);

  // // add userID to the cookie
  // res.cookie("xk_user_id", user);
  res.json({ authUrl });
});

//redirect user to /googleauth after they have given consent o sharing data
app.get("/googleauth", (req, res) => {
  // const { xk_user_id: user } = req.cookies;
  // const { code } = req.query;

  // if (!user) {
  //   console.log("User id cookie is not set");
  //   return res.sendStatus(403);
  // }

  // if (!code) {
  //   console.log("Authorization code was not provided");
  //   return res.sendStatus(400);
  // }

  // authCodeList[user] = code;
  // console.log("Received code: ", code, req);
  res.redirect("/");
});

app.get("/steps", async (req, res) => {
  // const { xk_user_id: user } = req.cookies;
  const { from, to, user, authCode } = req.query;

  if (!(user && from && to && authCode)) return res.sendStatus(403);

  const client = await getAuthWithToken(user, authCode);
  if (!client) return res.sendStatus(404);

  // fitness through the client will be requesting user data from google
  const fitness = google.fitness({
    version: "v1",
    auth: client,
  });

  try {
    const response = await fitness.users.dataset.aggregate({
      userId: "me",
      requestBody: {
        aggregateBy: [
          {
            dataTypeName: "com.google.step_count.delta",
            // dataSourceId:
            //   "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps",
          },
        ],
        bucketByTime: {
          // aggregate by days (24hours)
          durationMillis: 86400000,
        },
        startTimeMillis: from,
        endTimeMillis: to,
      },
    });

    if (response.status !== 200) {
      console.error("Aggregate request resulted in error,", response);
      return res.sendStatus(404);
    }

    res.json(response.data.bucket);
  } catch (e) {
    console.error("Something went wrong", e);
    res.sendStatus(500);
  }
});

app.get("/sleep", async (req, res) => {
  // const { xk_user_id: user } = req.cookies;
  const { from, to, user, authCode } = req.query;
  //trigger type conversion with + instead of using ParseInt
  const [fromDate, toDate] = [new Date(+from), new Date(+to)];
  
  if (!(user && from && to)) return res.sendStatus(403);

  const client = await getAuthWithToken(user, authCode);
  if (!client) return res.sendStatus(404);

  const fitness = google.fitness({
    version: "v1",
    auth: client,
  });
  try {
    const response = await fitness.users.sessions.list({
      activityType: "72",
      endTime: toDate.toISOString(),
      startTime: fromDate.toISOString(),
      userId: "me",
    });
    if (response.status !== 200) {
      console.error("Session request resulted in error,", response);
      return res.sendStatus(404);
    }

    res.json(response.data.session);

  } catch (e) { console.error("Something went wrong", e);
  res.sendStatus(500);
}
});

app.listen(port, () => {
  console.log(`Microservice is listening on address http://localhost:${port}/`);
});
