<?php

namespace Database\Seeders;

use App\Models\FileExtension;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class FileExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileExtensions =  [
            [
                'id'        => Str::uuid(),
                'extension' => 'doc',
                'description' => 'Microsoft Word 97 - 2003 Document'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'docx',
                'description' => 'Microsoft Word Document'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'xls',
                'description' => 'Microsoft Excel 97 - 2003 Worksheet'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'xlsx',
                'description' => 'Microsoft Excel Worksheet'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'ppt',
                'description' => 'Microsoft PowerPoint 97 - 2003 Presentation'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'pptx',
                'description' => 'Microsoft PowerPoint Presentation'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'pdf',
                'description' => 'Portable Document Format'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'rar',
                'description' => 'RAR Archive'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'zip',
                'description' => 'ZIP Archive'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'jpeg',
                'description' => 'Joint Photographic Experts Group'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'jpg',
                'description' => 'Joint Photographic Group'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'png',
                'description' => 'Portable Network Graphics'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'gif',
                'description' => 'Graphics Interchange Format'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'mp3',
                'description' => 'MPEG audio Layer 3'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'wav',
                'description' => 'Wave Form Audio Format'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'mp4',
                'description' => 'MPEG 4'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'exe',
                'description' => 'Directly Executable Program'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'ai',
                'description' => 'Adobe Illustrator Artwork'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'psd',
                'description' => 'Photoshop Bitmap File'
            ],
            [
                'id'        => Str::uuid(),
                'extension' => 'cdr',
                'description' => 'Vector Graphics Format'
            ]
        ];

        FileExtension::insert($fileExtensions);
    }
}
