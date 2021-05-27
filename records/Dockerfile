# FROM openjdk:16-jdk-alpine3.13 as build
# WORKDIR /workspace/app

# COPY mvnw .
# COPY .mvn .mvn
# COPY pom.xml .
# COPY src src

# RUN ./mvnw install -DskipTests
# RUN mkdir -p target/dependency && (cd target/dependency; jar -xf ../*.jar)

# FROM openjdk:16-jdk-alpine3.13
# RUN addgroup -S xk && adduser -S juser -G xk
# VOLUME /tmp
# USER juser
# ARG DEPENDENCY=/workspace/app/target/dependency
# COPY --from=build ${DEPENDENCY}/BOOT-INF/lib /app/lib
# COPY --from=build ${DEPENDENCY}/META-INF /app/META-INF
# COPY --from=build ${DEPENDENCY}/BOOT-INF/classes /app
# ENTRYPOINT [ "java", "-cp", "app:app/lib/*", "-Dspring.main.lazy-initialization=true", "org.xapik.records.RecordsApplication" ]

FROM openjdk:16-jdk-alpine3.13
VOLUME /tmp
COPY target/*.jar app.jar
ENTRYPOINT ["java","-jar","/app.jar"]