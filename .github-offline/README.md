# Local Testing Environment

This directory contains scripts to run the application's test suite in a local, containerized environment that replicates the CI setup.

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/) must be installed and running.

## Running the Tests

To run the test suite, execute the following command from the root of the repository:

```bash
./.github-offline/run-local-tests.sh
```

This script will:
1. Build a Docker image with the required PHP and MySQL extensions.
2. Run the test suite inside a container.
3. Remove the container after the tests are finished.
