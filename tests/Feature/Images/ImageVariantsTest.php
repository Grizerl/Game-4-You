<?php

namespace Tests\Feature\Images;

use App\Support\ImageVariants;
use App\Support\PublicImage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImageVariantsTest extends TestCase
{
    private string $stored = 'assets/_test_cover.png';

    protected function setUp(): void
    {
        parent::setUp();

        $image = imagecreatetruecolor(2000, 1000);
        imagepng($image, public_path($this->stored));
        imagedestroy($image);
    }

    protected function tearDown(): void
    {
        @unlink(public_path($this->stored));
        foreach (ImageVariants::WIDTHS as $width) {
            @unlink(public_path(ImageVariants::relativePath($this->stored, $width)));
        }

        parent::tearDown();
    }

    #[Test]
    public function variant_falls_back_to_original_until_generated(): void
    {
        $this->assertSame(asset($this->stored), PublicImage::variant($this->stored, 640));
    }

    #[Test]
    public function generates_downscaled_webp_variants_and_serves_them(): void
    {
        $this->assertSame(count(ImageVariants::WIDTHS), ImageVariants::generate($this->stored));

        $small = public_path(ImageVariants::relativePath($this->stored, 640));
        $this->assertFileExists($small);
        $this->assertSame(640, getimagesize($small)[0]);
        $this->assertSame(1280, getimagesize(public_path(ImageVariants::relativePath($this->stored, 1280)))[0]);
        $this->assertSame(asset(ImageVariants::relativePath($this->stored, 640)), PublicImage::variant($this->stored, 640));

        // повторна генерація нічого не перероблює
        $this->assertSame(0, ImageVariants::generate($this->stored));
    }

    #[Test]
    public function external_urls_and_missing_files_are_left_alone(): void
    {
        $this->assertSame(0, ImageVariants::generate('https://example.com/a.jpg'));
        $this->assertSame(0, ImageVariants::generate('assets/does-not-exist.jpg'));
        $this->assertSame('https://example.com/a.jpg', PublicImage::variant('https://example.com/a.jpg', 640));
        $this->assertNotNull(PublicImage::variant(null, 640, 'assets/images/games/placeholder.svg'));
    }
}
