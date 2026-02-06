<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Salah\LaravelCustomFields\Models\CustomField;
use Salah\LaravelCustomFields\Tests\Support\Models\Post;
use Salah\LaravelCustomFields\Tests\TestCase;

class FileFieldTest extends TestCase
{
    /** @test */
    public function it_can_upload_and_store_single_file()
    {
        Config::set('custom-fields.models', [
            'post' => Post::class,
        ]);
        Config::set('custom-fields.strict_validation', false);
        Storage::fake('public');

        $field = CustomField::create([
            'name' => 'Avatar',
            'type' => 'file',
            'model' => 'post',
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        // Simulate request
        $data = [
            'avatar' => $file,
        ];

        $model = new Post;
        $model->id = 1;
        $model->save();

        $model->saveCustomFields($data);

        // Assert DB
        $this->assertDatabaseHas('custom_field_values', [
            'custom_field_id' => $field->id,
            'model_id' => 1,
        ]);

        $value = $model->customFieldsValues->first();
        $decoded = json_decode($value->getAttributes()['value'], true);

        $this->assertArrayHasKey('path', $decoded);
        Storage::disk('public')->assertExists($decoded['path']);
    }

    /** @test */
    public function it_respects_configuration_for_disk_and_path()
    {
        Storage::fake('s3');
        Config::set('custom-fields.files.disk', 's3');
        Config::set('custom-fields.files.path', 'my-uploads');
        Config::set('custom-fields.models', [
            'post' => Post::class,
        ]);
        Config::set('custom-fields.strict_validation', false);

        $field = CustomField::create([
            'name' => 'Document',
            'type' => 'file',
            'model' => 'post',
        ]);

        $model = new Post;
        $model->id = 1;
        $model->save();

        $file = UploadedFile::fake()->create('doc.pdf');
        $model->saveCustomFields(['document' => $file]);

        $value = $model->customFieldsValues->first();
        $decoded = json_decode($value->getAttributes()['value'], true);

        // Verify Path contains configured folder
        $this->assertStringContainsString('my-uploads', $decoded['path']);

        // Verify File exists on configured disk
        Storage::disk('s3')->assertExists($decoded['path']);
    }

    /** @test */
    public function it_cleans_up_single_file_on_update()
    {
        Storage::fake('public');

        Config::set('custom-fields.models', [
            'post' => Post::class,
        ]);
        Config::set('custom-fields.strict_validation', false);

        $field = CustomField::create([
            'name' => 'Attachments',
            'type' => 'file',
            'model' => 'post',
        ]);

        $model = new Post;
        $model->id = 1;
        $model->save();

        // 1. Upload 1 file
        $file1 = UploadedFile::fake()->create('a.txt');
        $model->saveCustomFields(['attachments' => $file1]);

        $value1 = json_decode($model->fresh()->customFieldsValues->first()->getAttributes()['value'], true);
        $path1 = $value1['path'];

        Storage::disk('public')->assertExists($path1);

        // 2. Upload new file (Replace)
        $file2 = UploadedFile::fake()->create('c.txt');
        $model->updateCustomFields(['attachments' => $file2]);

        // Assert Old File Deleted
        Storage::disk('public')->assertMissing($path1);

        // Assert New File Exists
        $value2 = json_decode($model->fresh()->customFieldsValues->first()->getAttributes()['value'], true);
        Storage::disk('public')->assertExists($value2['path']);
    }
}
