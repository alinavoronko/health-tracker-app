# syntax=docker/dockerfile:experimental
FROM openjdk:15-jdk-alpine AS build
WORKDIR /workspace/app

COPY . /workspace/app
RUN --mount=type=cache,target=/root/.gradle ./gradlew clean build -x test
RUN mkdir -p build/dependency && (cd build/dependency; jar -xf ../libs/*.jar)

FROM openjdk:15-jdk-alpine
RUN addgroup -S xk && adduser -S juser -G xk
VOLUME /tmp
USER juser
ARG DEPENDENCY=/workspace/app/build/dependency
COPY --from=build ${DEPENDENCY}/BOOT-INF/lib /app/lib
COPY --from=build ${DEPENDENCY}/META-INF /app/META-INF
COPY --from=build ${DEPENDENCY}/BOOT-INF/classes /app

ENTRYPOINT [ "java", "-cp", "app:app/lib/*", "-Dspring.main.lazy-initialization=true", "org.xapik.friends.FriendsApplication" ]
