<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class FileUploader
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function encode(){
        $request = $this->requestStack->getCurrentRequest();
        $image = $request->files->all()['imageBlob']->getRealPath();
        $image = fopen($image, 'rb');
        return stream_get_contents($image);
        //fclose($image);
    }
    
}