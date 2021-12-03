# Run php script

Bash
```
docker run --rm -v $(pwd):/app/ php:7.4-cli php app/day-01.php
```

Fish
```
docker run --rm -v (pwd):/app/ php:7.4-cli php app/day-01.php
```