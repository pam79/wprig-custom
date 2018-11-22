<?php
/**
 * WP Rig Setup_Tests unit test class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Tests\Unit;

use WP_Rig\WP_Rig\Tests\Framework\Unit_Test_Case;
use Brain\Monkey\Functions;
use function WP_Rig\WP_Rig\setup_theme;
use function WP_Rig\WP_Rig\filter_embed_dimensions;
use function WP_Rig\WP_Rig\widgets_init;

/**
 * Class unit-testing the theme setup functions.
 *
 * @group hooks
 */
class Setup_Tests extends Unit_Test_Case {

	/**
	 * Internal data storage.
	 *
	 * @var array
	 */
	private $data_storage;

	/**
	 * Sets up the environment before each test.
	 */
	public function setUp() {
		parent::setUp();

		$this->data_storage = [];
	}

	/**
	 * Tests that the theme setup function performs the necessary logic.
	 *
	 * @covers setup_theme()
	 */
	public function test_setup_theme() {
		Functions\expect( 'load_theme_textdomain' )
			->once();

		Functions\when( 'add_theme_support' )->alias(
			function( $feature, ...$args ) {
				$this->data_storage[ $feature ] = $args;
			}
		);

		Functions\expect( 'register_nav_menus' )
			->with(
				array(
					'primary' => 'Primary',
				)
			)
			->once();

		setup_theme();

		$this->assertEqualSets(
			[
				'automatic-feed-links',
				'title-tag',
				'post-thumbnails',
				'html5',
				'custom-background',
				'customize-selective-refresh-widgets',
				'custom-logo',
				'wp-block-styles',
				'align-wide',
				'editor-color-palette',
				'editor-font-sizes',
				'amp',
			],
			array_keys( $this->data_storage )
		);
	}

	/**
	 * Tests that the embed dimensions filter callback returns the correct value.
	 *
	 * @covers filter_embed_dimensions()
	 */
	public function test_filter_embed_dimensions() {
		$result = filter_embed_dimensions( [] );

		$this->assertEquals(
			[ 'width' => 720 ],
			$result
		);
	}

	/**
	 * Tests that the widgets and sidebar initialization function performs the necessary logic.
	 *
	 * @covers widgets_init()
	 */
	public function test_widgets_init() {
		Functions\when( 'register_sidebar' )->alias(
			function( $args ) {
				$this->data_storage[ $args['id'] ] = $args;
			}
		);

		widgets_init();

		$this->assertEqualSets(
			[ 'sidebar-1' ],
			array_keys( $this->data_storage )
		);
	}
}