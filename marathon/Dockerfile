#syntax=docker/dockerfile:1
FROM mcr.microsoft.com/dotnet/sdk:5.0-alpine AS build
WORKDIR /source/app

COPY *.csproj ./
RUN dotnet restore -r linux-musl-x64

COPY . ./
RUN dotnet publish -c Release -o /app -r linux-musl-x64

FROM mcr.microsoft.com/dotnet/aspnet:5.0-alpine-amd64
WORKDIR /app
COPY --from=build /app ./

ENTRYPOINT ["dotnet", "marathon.dll"]
