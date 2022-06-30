<?php 
namespace App\EventListener;

use ApiPlatform\Core\Util\RequestAttributesExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use ApiPlatform\Core\EventListener\DeserializeListener as DecoratedListener;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;

class DeserializeListener{

    public function __construct(DenormalizerInterface $denormalizer, SerializerContextBuilderInterface $serializerContextBuilder, DecoratedListener $decorated)
    {
        $this->denormalizer = $denormalizer;
        $this->serializerContextBuilder = $serializerContextBuilder;
        $this->decorated = $decorated;
    }

    public function onKernelRequest(RequestEvent $event):void{

        $request = $event->getRequest();
        if($request->isMethodCacheable() || $request->isMethod(Request::METHOD_DELETE)){
            return;
        }
        if ($request->getContentType() == 'form') {
            $this->denormalizeFormRequest($request);
        } else {
            $this->decorated->onKernelRequest($event);
        }
    }
    private function denormalizeFormRequest(Request $request): void
    {
        $attributes = RequestAttributesExtractor::extractAttributes($request);
        //dd($attributes);
        if (!$attributes ) {
            return;
        }

        $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
        $data = $request->request->all();
        //dd($data);
        $files = $request->request->all();
        dd(array_merge($data,$files));
        // $populated = $request->attributes->get('data');
        // if (null !== $populated) {
        //     $context['object_to_populate'] = $populated;
        // }

        // $data = $request->request->all();
        // dd($data);
        // $object = $this->denormalizer->denormalize($data, $attributes['resource_class'], null, $context);
        // $request->attributes->set('data', $object);
    }
}