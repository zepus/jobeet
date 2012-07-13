<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new JobeetTestFunctional(new sfBrowser());
$browser->loadData();


// Expired jobs are not listed
$browser->info('1 - The homepage')->
        get('/')->
        with('request')->begin()->
            isParameter('module', 'job')->
            isParameter('action', 'index')->
        end()->
        with('response')->begin()->
            info('  1.1 - Expired jobs are not Listed')->
            checkElement('.jobs td.position:contains("expired")', false)->
        end()
        ;

 
// Only N jobs are listed for a category
$max = sfConfig::get('app_max_jobs_on_homepage');

$browser->info('1 - The homepage')->
        get('/')->
        info(sprintf('  1.2 - Only %s jobs are listed for a category', $max))->
        with('response')->
            checkElement('.category_programming tr', $max)
        ;


// A category has a link to the category page only if too many jobs
$browser->info('1 - The homepage')->
        get('/')->
        info('  1.3 - A category has a link to the category page only if too many jobs')->
        with('response')->begin()->
            checkElement('.category_design .more_jobs', false)->
            checkElement('.category_programming .more_jobs')->
        end()
        ;


// Jobs are sorted by date
$browser->info('1 - The homepage')->
        get('/')->
        info('  1.4 - Jobs are sorted by date')->
        with('response')->begin()->
            checkElement(sprintf('.category_programming tr:first a[href*="/%d/"]',
                    $browser->getMostRecentProgrammingJob()->getId()))->
        end()
        ;


// Each job on homepage is clickable
$job = $browser->getMostRecentProgrammingJob();

$browser->info('2 - The job page')->
        get('/')->
        
        info('  2.1 - Each job on the homepage is clickable and give detailed information')->
        click('Web Developer', array(), array('position' => 1))->
        with('request')->begin()->
            isParameter('module', 'job')->
            isParameter('action', 'show')->
            isParameter('company_slug', $job->getCompanySlug())->
            isParameter('location_slug', $job->getLocationSlug())->
            isParameter('position_slug', $job->getPositionSlug())->
            isParameter('id', $job->getId())->
        end()->
        
        info('  2.2 - A non-existent job forwards the user to a 404')->
        get('/job/foo-inc/milano-italy/0/painter')->
        with('response')->isStatusCode(404)
        ;

