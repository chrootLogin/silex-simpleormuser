<?php

namespace rootLogin\SimpleOrmUser\Provider;

use rootLogin\SimpleOrmUser\Manager\UserManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

class SimpleOrmUserServiceProvider implements ServiceProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     * @return mixed
     */
    public function register(Application $app) {
        $app['user.options'] = [
            'userClass' => 'rootLogin\SimpleOrmUser\Entity\User',
        ];

        $app['user.manager'] = $app->share(function($app) {
            $app['user.options.init']();

            $userManager = new UserManager($app);
            $userManager->setUserClass($app['user.options']['userClass']);
            $userManager->setUsernameRequired($app['user.options']['isUsernameRequired']);

            return $userManager;
        });
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function boot(Application $app) {}
}