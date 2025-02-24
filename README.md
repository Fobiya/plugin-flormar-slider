# Flormar Slider

Flormar Slider is a customizable slider plugin for WordPress that allows you to create beautiful and responsive sliders for your website. This plugin is easy to use and integrates seamlessly with your WordPress site.

## Features

- Create and manage sliders with ease
- Fully responsive design
- Customizable settings for each slider
- Shortcode support for easy embedding
- Lightweight and fast

## Installation

1. Download the plugin files.
2. Upload the `flormar-slider` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

The plugin provides a simple shortcode system to display product sliders. You can use the following shortcode variations:

### Basic Usage
```
[flormar-test-slider]
```
This will display all products in a slider.

### Price Range Filtering
You can filter products by price using the following parameters:

1. Filter by price range:
```
[flormar-test-slider min-price="10" max-price="50"]
```
Shows products with prices between 10 and 50

2. Filter by maximum price:
```
[flormar-test-slider max-price="50"]
```
Shows products with prices up to 50

3. Filter by minimum price:
```
[flormar-test-slider min-price="10"]
```
Shows products with prices from 10 and up

## Customization

You can customize the appearance of the slider by modifying the CSS in the `assets/css/style.css` file. For JavaScript functionality, edit the `assets/js/script.js` file.

## Contributing

If you would like to contribute to the Flormar Slider project, feel free to submit a pull request or open an issue on the repository.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.