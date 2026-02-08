<?php

namespace Salah\LaravelCustomFields\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Salah\LaravelCustomFields\Models\CustomField;
use Salah\LaravelCustomFields\Tests\Support\Models\Post;
use Salah\LaravelCustomFields\Tests\TestCase;

class StartFieldDeletionTest extends TestCase
{
    /** @test */
    public function it_cleans_up_files_when_custom_field_is_force_deleted()
    {
        Config::set('custom-fields.models', [
            'post' => Post::class,
        ]);
        Config::set('custom-fields.strict_validation', false);
        Storage::fake('public');

        // 1. Create a File Custom Field
        $field = CustomField::create([
            'name' => 'Resume',
            'type' => 'file',
            'model' => 'post',
        ]);

        // 2. Create a Post and attach a file
        $model = new Post;
        $model->id = 1;
        $model->save();

        $file = UploadedFile::fake()->create('resume.pdf');
        $model->saveCustomFields(['resume' => $file]);

        // 3. Verify file exists
        $value = $model->customFieldsValues()->first();
        $this->assertNotNull($value);

        $decoded = json_decode($value, true);
        $path = $decoded['value']['path'];
        Storage::disk('public')->assertExists($path);

        // 4. Force Delete the Custom Field
        // This should trigger cleanup of all associated values and their files
        $field->forceDelete();

        // 5. Verify file is deleted
        Storage::disk('public')->assertMissing($path);

        // 6. Verify value record is deleted
        $this->assertDatabaseMissing('custom_field_values', [
            'id' => $value->id,
        ]);
    }
}
