# imgurapi
Upload images by Api of ImgUR with a simple code

# how to use
Just create the object of class ImgurAPI, and use the method "sendImage()" by passing the path of the image you want to send
The return will be the path of the image hosted in ImgUR, if it does not send it will return blank

```php
#if you are sending an already hosted image
$IMAGE_PATH = 'https://www.site_name.com/image_to_send.jpg'

#if you are sending an image of a form
$IMAGE_PATH = $_FILES['upload']['tmp_name']

$imgUr = new ImgurAPI();
$img = $imgUr->sendImage($IMAGE_PATH);
print '<img src="'.$img.'" >';
```
