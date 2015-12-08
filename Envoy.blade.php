@servers([$server => $server])

@task('config')

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Ready to kick ' . $server . '... but I wont so lets start fresh. rm -rf /home/scraper')
  @endafter

  rm -rf /home/scraper

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Now we need some server requirements...installing')
  @endafter

  apt-get install apache2 php5 php5-curl libapache2-mod-php5 php5-mcrypt git php5-mysql -y

  curl -sS https://getcomposer.org/installer | php
  mv composer.phar /usr/local/bin/composer

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Composer installed globally, now I shall composer install...')
  @endafter

  touch ~/.ssh/id_rsa
  touch ~/.ssh/config

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Waiting for manual edits....')
  @endafter

  echo "--NEXT STEPS -- "
  echo "1. Add Private Key to ~/.ssh/id_rsa"
  echo "2. Add 'StrictHostKeyChecking no' to ~/.ssh/config"
  echo "4. Run clone"
@endtask

@task('clone')

  chmod 600 ~/.ssh/id_rsa

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Cloning Scraper, and coping env example')
  @endafter

  tmux new -d -s clone
  tmux send -t clone "git clone git@github.com:SHINDiiG/Scraper.git /home/scraper && cd /home/scraper && cp .env.example .env" ENTER

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Done...more manual input needed')
  @endafter

  echo "--NEXT STEPS -- "
  echo "Edit env with required information"
  echo "Run scrape"

@endtask

@task('scrape')

  cd /home/scraper

  composer install

  curl -sS https://gist.githubusercontent.com/SapioBeasley/1e63304a93d51c822b1a/raw | sh

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'New tmux session available for scrape job id ' . $job . "n/" . '-t scape' . "n/" . '-t import')
  @endafter

  tmux send -t scrape "php artisan scrape:run --id={{ $job }}" ENTER

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Scrape job id ' . $job . ' now scraping')
  @endafter

  tmux send -t import "php artisan tinker" ENTER
  tmux send -t import "Bus::dispatch(\$command = new App\Commands\ImportResultsCommand())" ENTER

  @after
    @slack('https://hooks.slack.com/services/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', '#suaray-scraper', 'Importing results ...')
  @endafter

@endtask
