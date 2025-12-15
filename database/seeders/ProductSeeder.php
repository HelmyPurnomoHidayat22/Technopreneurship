<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $pptCategory = Category::where('name', 'PPT')->first();
        $cvCategory = Category::where('name', 'CV')->first();
        $undanganCategory = Category::where('name', 'Undangan')->first();
        $notionCategory = Category::where('name', 'Notion')->first();

        $products = [
            [
                'category_id' => $pptCategory->id,
                'title' => 'Professional Business Presentation Template',
                'description' => 'Template PowerPoint profesional untuk presentasi bisnis dengan desain modern dan elegan. Cocok untuk pitch deck, laporan perusahaan, dan presentasi penting lainnya. Includes 50+ slide layouts yang dapat disesuaikan.',
                'price' => 99000,
            ],
            [
                'category_id' => $pptCategory->id,
                'title' => 'Creative Portfolio PowerPoint Template',
                'description' => 'Template PowerPoint kreatif untuk portfolio pribadi atau perusahaan. Desain fresh dengan animasi halus dan layout yang menarik. Perfect untuk showcase karya dan pencapaian.',
                'price' => 85000,
            ],
            [
                'category_id' => $cvCategory->id,
                'title' => 'Modern CV Template - Professional',
                'description' => 'Template CV modern dan profesional yang akan membuat resume Anda menonjol. Desain clean dan mudah dibaca oleh HR. Tersedia dalam format yang mudah diedit.',
                'price' => 75000,
            ],
            [
                'category_id' => $cvCategory->id,
                'title' => 'Creative CV Template - Designer',
                'description' => 'Template CV kreatif khusus untuk designer, developer, dan creative professionals. Desain unik dengan layout yang eye-catching namun tetap profesional.',
                'price' => 95000,
            ],
            [
                'category_id' => $undanganCategory->id,
                'title' => 'Wedding Invitation Template - Elegant',
                'description' => 'Template undangan pernikahan elegan dengan desain klasik yang timeless. Siap pakai dengan placeholder untuk foto, tanggal, dan detail acara. Perfect untuk pernikahan mewah.',
                'price' => 150000,
            ],
            [
                'category_id' => $undanganCategory->id,
                'title' => 'Birthday Party Invitation Template',
                'description' => 'Template undangan ulang tahun yang colorful dan fun. Cocok untuk berbagai usia dengan desain yang menarik dan playful. Mudah disesuaikan dengan tema pesta Anda.',
                'price' => 65000,
            ],
            [
                'category_id' => $notionCategory->id,
                'title' => 'Notion Productivity System Template',
                'description' => 'Sistem produktivitas lengkap untuk Notion dengan database, templates, dan workflows yang sudah disiapkan. Includes task management, habit tracker, dan project planning.',
                'price' => 125000,
            ],
            [
                'category_id' => $notionCategory->id,
                'title' => 'Notion Business Dashboard Template',
                'description' => 'Dashboard bisnis lengkap untuk Notion dengan CRM, sales tracking, inventory management, dan reporting. Perfect untuk small business dan startup.',
                'price' => 175000,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
