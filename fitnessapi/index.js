const express = require("express");
const cookieParser = require("cookie-parser");
const { google } = require("googleapis");

const port = 3000;

const app = express();
app.use(express.json());
app.use(cookieParser());
app.use(express.static("public"));

const CLIENT_ID =
  "741475589490-i7nfrlunhs6m9t59q23bqai37ad7kfrr.apps.googleusercontent.com";
const CLIENT_SECRET = "tJbUoBP2eBwb3UxEcqi6Pz6u";

const oAuthParams = [
  CLIENT_ID,
  CLIENT_SECRET,
  "http://localhost:3000/googleauth",
];

const scope = [
  "https://www.googleapis.com/auth/fitness.heart_rate.read",
  "https://www.googleapis.com/auth/fitness.sleep.read",
  "https://www.googleapis.com/auth/fitness.activity.read",
];

const authCodeList = {};
const tokenList = {};

async function getAuthWithToken(userId) {
  const oauth2Client = new google.auth.OAuth2(...oAuthParams);

  if (!tokenList[userId]) {
    if (!authCodeList[userId]) return null;

    const authCode = authCodeList[userId];
    const { tokens } = await oauth2Client.getToken(authCode);
    oauth2Client.setCredentials(tokens);
    tokenList[userId] = tokens;
  } else {
    oauth2Client.setCredentials(tokenList[userId]);
  }

  oauth2Client.on("tokens", (tokens) => {
    if (tokens.refresh_token) {
      tokenList[userId].refresh_token = tokens.refresh_token;
    }

    tokenList[userId].access_token = tokens.access_token;
  });

  return oauth2Client;
}

app.get("/google-url", (req, res) => {
  const oauth2Client = new google.auth.OAuth2(...oAuthParams);

  const authUrl = oauth2Client.generateAuthUrl({
    access_type: "offline",
    scope,
  });

  const { user } = req.query;

  if (!user) return res.sendStatus(403);

  res.cookie("xk_user_id", user);

  res.json({ authUrl });
});

app.get("/googleauth", (req, res) => {
  const { xk_user_id: user } = req.cookies;
  const { code } = req.query;

  if (!user) {
    console.log("User id cookie is not set");
    return res.sendStatus(403);
  }

  if (!code) {
    console.log("Authorization code was not provided");
    return res.sendStatus(400);
  }

  authCodeList[user] = code;

  res.redirect("/");
});

app.get("/steps", async (req, res) => {
  const { xk_user_id: user } = req.cookies;
  const { from, to } = req.query;

  if (!(user || from || to)) return res.sendStatus(403);

  const client = await getAuthWithToken(user);
  if (!client) return res.sendStatus(404);

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
            dataSourceId:
              "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps",
          },
        ],
        bucketByTime: {
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
    console.error('Something went wrong', e);
    res.sendStatus(500);
  }

});

app.listen(port, () => {
  console.log(`Microservice is listening on address http://localhost:${port}/`);
});
