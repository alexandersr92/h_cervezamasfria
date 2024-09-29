<?php
var_dump("llego hasta aqui");
require get_template_directory() . '/vendor/autoload.php';

use Aws\S3\S3Client;


function uploadImage($facturaImage)
{
  var_dump("llego hasta aqui2");
  var_dump($facturaImage);

  $region  = 'us-west-1';
  $version = 'latest';
  $access_key_id = get_field('access_key_id', 'option');
  $secret_access_key = get_field('secret_access_key', 'option');

  $bucket = 'superexpressverano2024';
  $factura_imagen_url = '';
  $wasUploaded = false;
  if (!empty($facturaImage["name"])) {


    $file_name = basename($facturaImage["name"]);
    var_dump($file_name);
    $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

    // Allow certain file formats 
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($file_type, $allowTypes)) {
      // File temp source 
      $file_temp_src = $facturaImage["tmp_name"][0];

      if (is_uploaded_file($file_temp_src)) {
        // Instantiate an Amazon S3 client 
        $s3 = new S3Client([
          'version' => $version,
          'region'  => $region,
          'credentials' => [
            'key'    => $access_key_id,
            'secret' => $secret_access_key,
          ]
        ]);

        // Upload file to S3 bucket 
        try {
          $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key'    => $file_name,
            'ACL'    => 'public-read',
            'SourceFile' => $file_temp_src
          ]);
          $result_arr = $result->toArray();

          if (!empty($result_arr['ObjectURL'])) {
            $s3_file_link = $result_arr['ObjectURL'];
            $factura_imagen_url = $s3_file_link;
          } else {
            $api_error = 'Upload Failed! S3 Object URL not found.';
          }
        } catch (Aws\S3\Exception\S3Exception $e) {
          $api_error = $e->getMessage();
        }

        if (empty($api_error)) {
          /*       $status = 'success';
          $statusMsg = "File was uploaded to the S3 bucket successfully!"; */
          $wasUploaded = true;
        } else {
          echo $api_error;
        }
      } else {
        echo  "File upload failed!";
      }
    } else {
      echo 'Sorry, only Word/Excel/Image files are allowed to upload.';
    }
  }

  return [
    'wasUploaded' => $wasUploaded,
    'factura_imagen_url' => $factura_imagen_url
  ];
}
