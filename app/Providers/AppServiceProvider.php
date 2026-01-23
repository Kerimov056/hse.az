<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Filesystem\FilesystemAdapter;

use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Google\Cloud\Storage\StorageClient;

use App\Models\Course;
use App\Models\ResourceItem;
use App\Observers\CourseObserver;
use App\Observers\ResourceItemObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Google Cloud Storage disk
        Storage::extend('gcs', function ($app, $config) {
            $keyFilePath = $config['key_file_path'] ?? null;

            $client = new StorageClient([
                'projectId'   => $config['project_id'] ?? null,
                'keyFilePath' => $keyFilePath && !str_starts_with($keyFilePath, '/')
                    ? base_path($keyFilePath)
                    : $keyFilePath,
            ]);

            $bucket     = $client->bucket($config['bucket']);
            $prefix     = $config['path_prefix'] ?? '';
            $adapter    = new GoogleCloudStorageAdapter($bucket, $prefix);
            $filesystem = new Filesystem($adapter, [
                'visibility' => $config['visibility'] ?? 'public',
            ]);

            return new FilesystemAdapter($filesystem, $adapter, $config);
        });

        // Global: navbar dropdown-lar üçün holding name list-lərini bütün view-lara ver
        View::composer('*', function ($view) {

            $getCourseHoldings = function (string $typeConst) {
                return Course::query()
                    ->type($typeConst)
                    ->whereNotNull('courseHoldingName')
                    ->where('courseHoldingName', '!=', '')
                    ->select('courseHoldingName')
                    ->distinct()
                    ->orderBy('courseHoldingName')
                    ->pluck('courseHoldingName');
            };

            $courseHoldings = Cache::remember('nav.course_holdings', now()->addMinutes(5), function () use ($getCourseHoldings) {
                return $getCourseHoldings(Course::TYPE_COURSE);
            });

            $serviceHoldings = Cache::remember('nav.service_holdings', now()->addMinutes(5), function () use ($getCourseHoldings) {
                return $getCourseHoldings(Course::TYPE_SERVICE);
            });

            $topicHoldings = Cache::remember('nav.topic_holdings', now()->addMinutes(5), function () use ($getCourseHoldings) {
                return $getCourseHoldings(Course::TYPE_TOPIC);
            });

            // Resources holding dropdown
            $resourceHoldings = Cache::remember('nav.resource_holdings', now()->addMinutes(5), function () {
                return ResourceItem::query()
                    ->whereNotNull('holdingName')
                    ->where('holdingName', '!=', '')
                    ->select('holdingName')
                    ->distinct()
                    ->orderBy('holdingName')
                    ->pluck('holdingName');
            });

            $view->with(compact(
                'courseHoldings',
                'serviceHoldings',
                'topicHoldings',
                'resourceHoldings'
            ));
        });

        // Observers
        Course::observe(CourseObserver::class);
        ResourceItem::observe(ResourceItemObserver::class);
    }
}
