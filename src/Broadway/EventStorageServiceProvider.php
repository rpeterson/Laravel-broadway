<?php namespace Nwidart\LaravelBroadway\Broadway;

use Illuminate\Support\ServiceProvider;

class EventStorageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Nwidart\LaravelBroadway\EventStore\EventStoreFactory',
            'Nwidart\LaravelBroadway\EventStore\Broadway\BroadwayEventStoreFactory'
        );

        $this->app->bind(
            'Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface',
            'Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory'
        );

        $this->app->bind('Broadway\EventStore\EventStoreInterface', function ($app) {
            $driver = $app['config']->get('broadway.event-store.driver');

            return $app['Nwidart\LaravelBroadway\EventStore\EventStoreFactory']->make($driver)->getDriver();
        });
    }
}
