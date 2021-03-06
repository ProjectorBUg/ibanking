<?php

namespace ProjectorBUg\IBanking;

use Illuminate\Support\Manager;

class IBankingManager extends Manager
{
    public function bank($driver)
    {
        return $this->driver($driver);
    }

    protected function createBcaDriver()
    {
        $config = $this->app['config']['services.bca'];

        return $this->buildProvider(
            '\ProjectorBUg\IBanking\Providers\BCAProvider', $config
        );
    }

    protected function createMandiriDriver()
    {
        $config = $this->app['config']['services.mandiri'];

        return $this->buildProvider(
            '\ProjectorBUg\IBanking\Providers\MandiriProvider', $config
        );
    }

    /**
     * Build an IBanking provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \ProjectorBUg\IBanking\Providers\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            app('ProjectorBUg\IBanking\Contracts\Parser'),
            $config['username'], $config['password']
        );
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Internet Banking driver was specified.');
    }
}
