<?php
/**
 * Service class to register services.
 *
 * @package AISmartSuggestions\Core
 */

declare(strict_types=1);

namespace AISmartSuggestions\Core;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use AISmartSuggestions\Core\Contracts\ConfigInterface;

/**
 * Service class
 *
 * @since 1.0
 */
class Service {
	/**
	 * Service instance.
	 *
	 * @since 1.0
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * Container instance.
	 *
	 * @since 1.0
	 *
	 * @var Container
	 *
	 * @access protected
	 */
	protected Container $container;

	/**
	 * Service constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->container = Container::instance();
	}

	/**
	 * Get the service instance.
	 *
	 * @since 1.0
	 *
	 * @return self
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register and Load a config file.
	 *
	 * @since 1.0
	 *
	 * @param string $path The plugin path.
	 * @param string $file The config file to load.
	 *
	 * @return self
	 *
	 * @throws InvalidArgumentException If the file is not found.
	 */
	public function set_config( string $path, string $file ): self {
		self::instance()
			->register_config( $path )
			->load( $file );

		return $this;
	}

	/**
	 * Register WordPress classes
	 *
	 * @since 1.0
	 *
	 * @return self
	 */
	public function set_services(): self {
		return $this;
	}

	/**
	 * Register default config service.
	 *
	 * Keep in mind that,
	 * ContainerBuilder is available without loaded config file.
	 *
	 * @since 1.0
	 *
	 * @param string $path The plugin path.
	 *
	 * @return ConfigInterface
	 */
	private function register_config( string $path ): ConfigInterface {
		$builder = $this->container->get_container_builder();

		$this->container
			->register( 'fileLocator', FileLocator::class )
			->addArgument( $path );

		$this->container
			->register( 'yamlFileLoader', YamlFileLoader::class )
			->addArgument( $builder )
			->addArgument( new Reference( 'fileLocator' ) );

		$this->container
			->register( 'config', Config::class )
			->addArgument( new Reference( 'yamlFileLoader' ) );

		return $this->container->get( 'config' );
	}
}
