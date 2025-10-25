#!/bin/bash

# This script builds a Docker image, runs the test suite in a container,
# and then cleans up the container.

# Exit immediately if a command exits with a non-zero status.
set -e

# Define the image and container names.
IMAGE_NAME="php-addressbook-test"
CONTAINER_NAME="php-addressbook-test-container"

# Function to stop and remove the container.
cleanup() {
    echo "Stopping and removing the container..."
    docker stop "$CONTAINER_NAME" >/dev/null 2>&1 || true
    docker rm "$CONTAINER_NAME" >/dev/null 2>&1 || true
}

# Set a trap to run the cleanup function on script exit.
trap cleanup EXIT

# Build the Docker image.
echo "Building the Docker image..."
docker build -t "$IMAGE_NAME" -f .github-offline/Dockerfile .

# Start a container in the background.
echo "Starting the container..."
docker run -d --name "$CONTAINER_NAME" "$IMAGE_NAME"

# Start the MySQL server.
echo "Starting the MySQL server..."
docker exec "$CONTAINER_NAME" service mysql start

# Wait for the server to be ready.
echo "Waiting for the server to start..."
sleep 5

# Run the tests inside the container.
echo "Running the test suite..."
docker exec "$CONTAINER_NAME" php test/index.php

echo "Tests finished."
