# Basic optimization

To optimize any image, simply call the `optimize()` method on it.

`$image->optimize()`

Optimization can be combined and chained with other API methods.
Make sure to first resize and then optimize to only compress the final image.


`$image->size(800,600)->optimize()->url`

# Automatic optimization

In addition to manually calling `optimize()`, the module has an option to automatically optimize all image variations on resize. This is the recommended way to use this module and useful if you prefer not to litter your template files with calls to `optimize()`. Just check the module setting _Automatically optimize image variations_.

When in auto-mode, you can disable image optimization for single files by passing an `optimize` flag along with your ImageResizer options.

`$image->size(800, 600, ['optimize' => false])`

# Overwriting compression settings

To apply different optimization settings for single images, pass an options array to the `optimize()` method. Passing a string instead of an array is a shortcut for setting the quality.

`$image->optimize('medium') // Set quality to medium`  
`$image->optimize(['quality' => 'low', 'dpr' => 2]) // Set quality to low and enable hi-dpi mode`

When in auto mode, just pass the `optimize` options along with your ImageResizer options. To disable optimization, pass `false`.

`$image->size(800, 600, ['optimize' => 'medium'])`  
`$image->size(800, 600, ['optimize' => ['quality' => 'low', 'dpr' => 2]])`  
`$image->size(800, 600, ['optimize' => false])`

# Filenames

Optimized images will be suffixed, e.g. `image.jpg` becomes `image.optim.jpg`. You can configure the suffix in the module settings.

Image variations optimized in auto mode will **not** be suffixed and will keep their filename.
