<?php

namespace Drupal\bold_test_configuration\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'DogOfDayBlock' block.
 *
 * @Block(
 *  id = "dog_of_day_block",
 *  admin_label = @Translation("Dog of day block"),
 * )
 */
class DogOfDayBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Cache\CacheBackendInterface definition.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cacheDefault;

  /**
   * Drupal\Core\Config\ConfigManagerInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigManagerInterface
   */
  protected $configManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->cacheDefault = $container->get('cache.default');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    //todo adicionar configuração e cache por injeção de dependencia
    $config = \Drupal::config('dogbreeds.settings');
    $url = $config->get('url_get_image');

    $config = \Drupal::config('dogconfiguration.settings');
    $dogBreed = $config->get('dog_breed');

          $photo_path = $this->cacheDefault->get("image_cache_".$dogBreed);

          if(empty($photo_path)){
            $url = str_replace("breed_name", $dogBreed, $url);

            $client = \Drupal::httpClient();
            $request = $client->get($url);
            $response = $request->getBody();

            $file_path = json_decode($response->__toString(), true);

            if(!empty($file_path['message'])){
              $photo_path = $file_path['message'];
              $this->cacheDefault->set("image_cache_".$dogBreed, $photo_path,60*60*24);
            }
          }


    $build = [];
    $build['#theme'] = 'dog_of_day_block';
    if(empty($photo_path)){
      $build['#content'] = 'Não foi possivel carregar a imagem';
    }else{
      $build['#image'] = $photo_path;
    }
    return $build;
  }

}
