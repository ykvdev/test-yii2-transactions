# Starkkraft Test Task

## Install

1. Go to your server projects directory.
1. Clone this project from repository: `git clone https://bitbucket.org/atoumus/test_starkkraft.git && cd ./test_starkkraft`.
1. Install composer deps: `composer install`.
1. Load MySQL dump: `mysql -u username -p password test_starkkraft < ./test_starkkraft.sql`.
1. Run PHP built-in server: `./yii serve 0.0.0.0 -p 8000`.
1. Go to: http://{your-ip-address}:8000 in browser.

## CLI Transactions Normalization Command

Usage examples:
```bash
# Preview for normalization changes (but not apply its)
./yii transactions/normalize

# Execute normalization changes for 10 backs
./yii transactions/normalize -e -l 10

# Execute normalization changes for max 1000 backs (by default)
./yii transactions/normalize -e
```

After running above commands, see the log: `runtime/logs/transactions_normalize.log`.