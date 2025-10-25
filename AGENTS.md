## Agent Instructions

Before proposing a push, you must run the offline GitHub Actions to ensure that all tests pass.

To run the tests, execute the following command from the root of the repository:

```bash
./.github-offline/run-local-tests.sh
```

**Programmatic Check:**

```bash
#!/bin/bash
if ! sudo ./.github-offline/run-local-tests.sh; then
  echo "The offline GitHub Actions failed. Please fix the tests before proposing a push."
  exit 1
fi
```
