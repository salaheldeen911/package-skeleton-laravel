<?php

namespace CustomFields\LaravelCustomFields;

use CustomFields\LaravelCustomFields\Commands\InstallCommand;
use CustomFields\LaravelCustomFields\Commands\LaravelCustomFieldsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCustomFieldsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-custom-fields')
            ->hasConfigFile('custom-fields')
            ->hasMigration('create_custom_fields_table')
            ->hasCommand(LaravelCustomFieldsCommand::class)
            ->hasCommand(InstallCommand::class);

        // Always register views, user might validly use them even in API mode if they want emails etc,
        // or we just enable them if web is enabled. For now, let's keep it simple and always register views
        // if the package has them. The config optimization is better done via route loading.
        $package->hasViews('custom-fields');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(FieldTypeRegistry::class, function () {
            $registry = new FieldTypeRegistry;
            $registry->register(new \CustomFields\LaravelCustomFields\FieldTypes\TextField);
            $registry->register(new \CustomFields\LaravelCustomFields\FieldTypes\SelectField);
            // $registry->register(new \CustomFields\LaravelCustomFields\FieldTypes\CheckboxField()); // User removed file? No I created it.
            $registry->register(new \CustomFields\LaravelCustomFields\FieldTypes\CheckboxField);
            $registry->register(new \CustomFields\LaravelCustomFields\FieldTypes\NumberField);
            $registry->register(new \CustomFields\LaravelCustomFields\FieldTypes\PhoneField);

            return $registry;
        });

        $this->app->singleton(ValidationRuleRegistry::class, function () {
            $registry = new ValidationRuleRegistry;
            $registry->register(new \CustomFields\LaravelCustomFields\ValidationRules\MinRule);
            $registry->register(new \CustomFields\LaravelCustomFields\ValidationRules\MaxRule);
            $registry->register(new \CustomFields\LaravelCustomFields\ValidationRules\RegexRule);
            $registry->register(new \CustomFields\LaravelCustomFields\ValidationRules\RequiredRule);
            $registry->register(new \CustomFields\LaravelCustomFields\ValidationRules\PhoneRule);

            return $registry;
        });
    }

    public function packageBooted(): void
    {
        if (config('custom-fields.routing.web.enabled', true)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        if (config('custom-fields.routing.api.enabled', false)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        }
    }
}
