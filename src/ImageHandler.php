<?php


namespace App;


use Slim\Psr7\UploadedFile;

/**
 * Class ImageHandler
 * @package App
 */
class ImageHandler {

	/**
	 * @var false|resource
	 */
	private $finfo;
	/**
	 * @var string the path to use to locate the pictures
	 */
	private $base_path;
	/**
	 * @var string the prefix to apply to the generated names of the files
	 */
	private $prefix;
	/**
	 * @const a regex defining the accepted types to host
	 */
	private const ACCEPTED_TYPES = '%^image\/[a-z]+$%';

	/**
	 * ImageHandler constructor.
	 * @param $prefix string the prefix to apply to the generated names of the files
	 */
	public function __construct($prefix) {
		$this->finfo = finfo_open(FILEINFO_MIME_TYPE);
		$this->base_path = $_ENV['IMAGES_DEFAULT_LOCATION'];
		if (!file_exists($this->base_path)) {
			mkdir($this->base_path, 0777, true);
		}
		$this->prefix = $prefix;
	}

	/**
	 * @param UploadedFile $file
	 * @return false|int
	 *
	 * Check if the mime type is an accepted one
	 */
	public function checkIntegrity(UploadedFile $file) {
		$file_mime_type = finfo_file($this->finfo, $file->getFilePath());
		return preg_match(self::ACCEPTED_TYPES, $file_mime_type);
	}

	/**
	 * @param UploadedFile $file
	 * @param false $do_thumbnail if the function must generate a thumbnail for this image
	 * @return array
	 *
	 * Save an uploaded file and give it an unique name
	 * Generate a thumbnail if specified
	 */
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

	/**
	 * @param string $filename the name of the file without extension
	 * @param string $ext the file's extension
	 * @return string the global path of the generated thumbnail
	 *
	 * generate a 200x200 squared thumbnail for a file
	 */
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
