<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\CityCollection;
use App\Service\OpenWetherApiService;
use Symfony\Component\HttpKernel\KernelInterface;

class ApiEndpointController extends AbstractController {

    const WEATHER_API_ICON_URL ='http://openweathermap.org/img/wn/{iconID}@2x.png';
    const WEATHER_API_BASE_URL = 'api.openweathermap.org/data/2.5/weather';
    /**
     *@Route("/api/weather/{cityName}", name="city-name")
     */
    public function getCity ($cityName, KernelInterface $appKernel)
    {
        $cityCollectionRepo = $this->getDoctrine()->getRepository(CityCollection::class);
        $accurateCity = $cityCollectionRepo->findMatchingCity($cityName, 10, 'GB');
        $cityData =[];
        if(count($accurateCity) >= 1) {    
            foreach($accurateCity as $city) {
                $cityData[] =[
                    'reference_id' => $city->getReferenceId(),
                    'name' => $city->getName(),
                    'state'=> $city->getState(),
                    'country'=> $city->getCountry(),
                ];
            }
            $html = $this->renderView('utilities/CitySuggections.html.twig', ["data" => $cityData]);
        } else {
            return new JsonResponse(['error' => 'No city found'], 200);
        }

        return new JsonResponse(["html"=> $html], 200);
    }
    /**
     *@Route("/api/city/{cityId}", name="city-id")
     */
    public function getCityById ($cityId, OpenWetherApiService $openWetherApiService)
    {
        $data = [
            'id' => $cityId,
            'appid' => $_ENV['OPENWEATHER_APIKEY'],
            'units' => 'metric'
        ];
        $quertString = http_build_query($data);
        $header =[];
        $method = 'GET';
        $url = self::WEATHER_API_BASE_URL.'?'.http_build_query($data);
        $apiResposne = $openWetherApiService->makeApiRequest($url, $header, [], $method);
        if($apiResposne['weather']) {
            $iconUrl = str_replace('{iconID}', $apiResposne['weather'][0]['icon'], self::WEATHER_API_ICON_URL);
        }

        $returnData = [
            'temparature' => $apiResposne['main']['temp'],
            'feels_like'  => $apiResposne['main']['feels_like'],
            'humidity'     => $apiResposne['main']['humidity'],
            'min_temparature' => $apiResposne['main']['temp_min'],
            'max_temparature'=> $apiResposne['main']['temp_max'],
            'wind_speed'    => $apiResposne['wind']['speed'],
            'icon'      => $iconUrl,
            'city_name'     => $apiResposne['name'],
            'description'   => $apiResposne['weather'][0]['description']
        ];
        if(isset($apiResposne['rain'])){
            $returnData['rain'] =  $apiResposne['rain']['1h'];
        }
        return $this->render('utilities/WeatherCard.html.twig', $returnData);
        return new JsonResponse( $returnData, 200);

 
    }
}