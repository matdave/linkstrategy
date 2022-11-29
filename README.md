# Link Strategy

This is a simple link strategy extra for MODX Revolution 3.x. It allows you to review the links used on your website, and find orphaned pages, link text variations, and external links.

## Installation

Install via package management. To generate the initial link stats, go to the Link Strategy manager page and click on the "Regenerate Links" button. This will take a while, depending on the size of your site. If this fails, you may need to manually run the included indexing script via CLI or cron. 

## Manual Link Indexing

If the automatic indexing fails, you can run the included indexing script manually. This is useful if you have a large site, or if you want to run the indexing script via cron.

To run the indexing script, you need to SSH into your server and run the following command:

    php /path/to/your/modx/core/components/linkstrategy/cron/generate.php

Once completed, this will output the number of resources indexed. You can then go to the Link Strategy manager page and verify it is showing the newly discovered links.

## Automatic Indexing

In general, the automatic indexing should work fine. It renders a page on save, and scans it for links. However, the links can change if you make adjustments to a template or chunk in your site that would affect the frontend links. If this happens, you can run the indexing script manually to update the links, or go to the manager page and click "Regenerate Links".

## Disable Automatic Indexing

Due to the way automatic indexing works, it may slow down the save event on your site depending on how your site is set up. If you want to disable automatic indexing, you can do so by setting the `linkstrategy.allow_regenerate_onsave` system setting to `No`. It is recommended you then run the indexing script manually via cron.

## Disable "Regenerate Links" Button

In the event you have a large site that consistently fails to generate links with the provided button. You can disable it in system settings. This will prevent the button from showing up in the manager page. It is recommended you then run the indexing script manually via cron.

To disable the button, set the system setting `linkstrategy.allow_regenerate_button` to `No`.
