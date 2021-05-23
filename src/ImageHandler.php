<?php


namespace App;


use Slim\Psr7\UploadedFile;

class ImageHandler {

	private $finfo;
	private $base_path;
	private $prefix;
	private const ACCEPTED_TYPES = '%^image\/[a-z]+$%';

	public function __construct($prefix) {
		$this->finfo = finfo_open(FILEINFO_MIME_TYPE);
		$this->base_path = $_ENV['IMAGES_DEFAULT_LOCATION'];
		if (!file_exists($this->base_path)) {
			mkdir($this->base_path, 0777, true);
		}
		$this->prefix = $prefix;
	}

	public function checkIntegrity(UploadedFile $file) {
		$file_mime_type = finfo_file($this->finfo, $file->getFilePath());
		return preg_match(self::ACCEPTED_TYPES, $file_mime_type);
	}

	public function processFile(UploadedFile $file, $do_thumbnail=false): array {
		$paths = [];
		$ext = '.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
		$filename = uniqid($this->prefix);
		$paths['original'] = $this->base_path . DIRECTORY_SEPARATOR . $filename . $ext;
		$file->moveTo($paths['original']);
		if ($do_thumbnail) {
			$paths['thumbnail'] = $this->generateThumbnail($filename, $ext);
		}
		return $paths;
	}

	public function generateThumbnail(string $filename, string $ext): string {
		$image = imagecreatefromstring(file_get_contents($this->base_path . DIRECTORY_SEPARATOR . $filename . $ext));

		$width = imagesx($image);
		$height = imagesy($image);

		$thumb_width = 200;
		$thumb_height = 200;

		$original_ratio = $width / $height;
		$thumb_ratio = $thumb_width / $thumb_height;

		if ( $original_ratio >= $thumb_ratio )
		{
			$new_height = $thumb_height;
			$new_width = $width / ($height / $thumb_height);
		}
		else
		{
			$new_width = $thumb_width;
			$new_height = $height / ($width / $thumb_width);
		}

		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

		imagecopyresampled($thumb,
			$image,
			0 - ($new_width - $thumb_width) / 2,
			0 - ($new_height - $thumb_height) / 2,
			0, 0,
			$new_width, $new_height,
			$width, $height);

		$thumb_file_location = $this->base_path . DIRECTORY_SEPARATOR. $filename . '_thumb' . $ext ;
		imagejpeg($thumb, $thumb_file_location, 80);
		return $thumb_file_location;
	}
}
