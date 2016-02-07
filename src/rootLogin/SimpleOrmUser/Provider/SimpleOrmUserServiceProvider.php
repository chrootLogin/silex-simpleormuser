<?php

namespace rootLogin\SimpleOrmUser\Provider;

use rootLogin\SimpleOrmUser\Manager\UserManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

class SimpleOrmUserServiceProvider implements ServiceProviderInterface
{
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

        $this->addDoctrineOrmMappings($app);
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function boot(Application $app) {}

    /**
     * @param Application $app
     */
    protected function addDoctrineOrmMappings(Application $app)
    {
        if (!isset($app['orm.ems.options'])) {
            $app['orm.ems.options'] = $app->share(function () use ($app) {
                $options = array(
                    'default' => $app['orm.em.default_options']
                );
                return $options;
            });
        }

        $app['orm.ems.options'] = $app->share($app->extend('orm.ems.options', function (array $options) {
            $options['default']['mappings'][] = array(
                'type' => 'annotation',
                'namespace' => 'rootLogin\SimpleOrmUser\Entity',
                'path' => $this->getEntityPath(),
                'use_simple_annotation_reader' => false,
            );
            return $options;
        }));
    }

    /**
     * @return string
     */
    protected function getEntityPath()
    {
        return realpath(__DIR__ . "/../Entity/");
    }
}