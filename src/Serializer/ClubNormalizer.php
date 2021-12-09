<?php

namespace App\Serializer;

use App\Entity\Club;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class ClubNormalizer implements ContextAwareNormalizerInterface
{
    private $normalizer;
    private $urlhelper;
    private $params;

    public function __construct(
        ObjectNormalizer $normalizer,
        UrlHelper $urlhelper,
        ParameterBagInterface $params
    ) {
        $this->normalizer = $normalizer;
        $this->urlhelper = $urlhelper;
        $this->params = $params;
    }

    public function normalize($club, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($club, $format, $context);

        if(!empty($club->getEscudo())) {
            $data['escudo'] = $this->urlhelper->getAbsoluteUrl($this->params->get('storagepath') . $club->getEscudo());
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = []){
        return $data instanceof Club;
    }
}