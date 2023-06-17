<?php
// Get the image URL and user input for text
$imageUrl = $_POST['image_url'];
$text = $_POST['text'];

// Load the image from the URL
$image = imagecreatefrompng($imageUrl);

// Set the text color and font
$textColor = imagecolorallocate($image, 255, 255, 255); // White color
$font = 'image/font/WixMadeforText-Italic.ttf'; // Replace with the path to your font file

// Set the text position
$textPositionX = 50;
$textPositionY = 100;

// Overlay the text on the image
imagettftext($image, 24, 0, $textPositionX, $textPositionY, $textColor, $font, $text);

// Generate a unique output path for each user
$timestamp = time(); // Get current timestamp
$outputPath = "image/created_memes/user_$timestamp.png"; // Modify the path format as desired

// Export the combined image as PNG
imagepng($image, $outputPath);

// Free up memory
imagedestroy($image);

// Generate the link to the exported image
$downloadLink = "<a href='$outputPath'>$outputPath</a>";

// Display the link to the exported image
echo "Modified image: $downloadLink";

// Initiate self-destruction asynchronously
echo <<<SCRIPT
<script>
    setTimeout(function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_image.php?path=$outputPath", true);
        xhr.send();
    }, 300000); // 5 minutes in milliseconds
</script>
SCRIPT;
?>