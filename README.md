# ImageOptim

This ProcessWire module is a wrapper around [ImageOptim](https://imageoptim.com), a service that compresses and optimizes images in the cloud. ImageOptim currently handles JPG, PNG and GIF files.

Please refer to their site for [API details](https://imageoptim.com/api) and [pricing information](https://imageoptim.com/api/pricing).

![Module configuration screen](https://github.com/philippdaun/ImageOptim/raw/master/ImageOptim.png)

## Installation

Install the module like any other ProcessWire module, by either copying the folder into your `/site/modules/` directory or installing it via the admin.

## Register with ImageOptim

To compress images, you first need to [sign up for an ImageOptim account](https://imageoptim.com/api/register). They offer a free trial.

If you already have an account, you can find your username in the [ImageOptim dashboard](https://imageoptim.com/api/dash).

## Usage

Images can be optimized by calling the `optimize()` method on any image. The module also has an automatic mode that optimizes all image variations after resizing. This is the recommended way to use this module since it leaves the original image uncompressed, but optimizes all derivative images.

For detailed usage instructions and all API parameters, see [USAGE.md](./USAGE.md)

## Module options

The compression level can be set globally. Alternatively, compression settings can be set per filetype, e.g. medium quality for JPEGs and low quality for PNGs. For details, see the module configuration screen.

Optimized files are renamed: `*.jpg` becomes `*.optim.jpg`. This suffix can be configured in the module settings.

Note that in automatic mode, files are not renamed but swapped in place.

## Additional resources

- [ImageOptim service](https://imageoptim.com)
- [ImageOptim pricing](https://imageoptim.com/api/pricing)
- [ImageOptim API details](https://imageoptim.com/api)

## License

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.

(See included LICENSE file for full license text.)
