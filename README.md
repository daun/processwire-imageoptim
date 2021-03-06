# ProcessWire ImageOptim

This ProcessWire module is a wrapper around [ImageOptim](https://imageoptim.com), a service that compresses and optimizes images in the cloud. ImageOptim currently handles JPG, PNG and GIF files.

Please refer to their site for [API details](https://imageoptim.com/api) and [pricing information](https://imageoptim.com/api/pricing).

![Module configuration screen](https://github.com/daun/processwire-imageoptim/raw/master/ImageOptim.png)

## Installation

Install the module like any other ProcessWire module, by either copying the folder into your `/site/modules/` directory or installing it via the admin.

## Register with ImageOptim

To compress images, you first need to [sign up for an ImageOptim account](https://imageoptim.com/api/register). They offer a free trial.

If you already have an account, you can find your username in the [ImageOptim dashboard](https://imageoptim.com/api/dash).

## Usage

See [Usage](./USAGE.md) for detailed instructions and all API parameters.

Images can be optimized by calling the `optimize()` method on any image. The module also has an automatic mode that optimizes all image variations after resizing. This is the recommended way to use this module since it leaves the original image uncompressed, but optimizes all derivative images.

## Module options

The compression level can be set globally. Alternatively, compression settings can be set per filetype, e.g. medium quality for JPEGs and low quality for PNGs. For details, see the module configuration screen.

Optimized files are renamed: `*.jpg` becomes `*-optim.jpg`. This suffix can be configured in the module settings.

Note that in automatic mode, files are not renamed but swapped in place.

## Additional resources

- [ImageOptim service](https://imageoptim.com)
- [ImageOptim pricing](https://imageoptim.com/api/pricing)
- [ImageOptim API details](https://imageoptim.com/api)

## License

[GPL](https://opensource.org/licenses/GPL-3.0)
