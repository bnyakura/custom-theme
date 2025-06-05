<<<<<<< HEAD
# Custom WordPress Theme

A modern, responsive WordPress theme built with ACF blocks and Gutenberg.

## Installation

1. Upload the `custom` folder to `/wp-content/themes/`
2. Activate the theme in WordPress admin
3. Install and activate Advanced Custom Fields Pro (ACF) plugin
`NB THE THEME ONLY WORKS WITH THE ACF PRO PLUGIN`
4. Import ACF field groups from the `acf-json` folder
   
### What Happens After Installation

- The following pages are automatically created:
  - **Campus**
  - **Learn**
  - **Blog**
  - **About**
  - **Careers and Study Opportunities**
- A menu is created, the above pages are added to it, and the menu is set as the Primary menu and added to header.
- The page titled **Careers and Study Opportunities** is set as the front page, and populated with content as shown in the design files.
- A custom post type called **Latest Blogs** is created.
- Three sample blog posts are imported and displayed in a grid layout on the front page.


### Available Custom Blocks

- **LATEST BLOS Block**: Grid layout for showcasing latest blogs
- **Breadcrumb Block**: Displays pages and posts breadcrumbs

### Adding New Blocks

1. Register the block in `inc/acf-blocks.php`
2. Create the template in `template-parts/blocks/`
3. Add ACF field groups to `acf-json/`
4. Style the block in `assets/css/blocks.css`

## Customization

### Page content editing
You can customize the pages using the Gutenberg editor. To edit the front page, open the **Careers and Study Opportunities** page in the WordPress admin and use the Block Editor to add or modify content as needed.

### Colors and Typography

Edit the CSS custom properties in `inc/theme-styles.php` or use `theme.json` for design tokens.

### Adding Custom Post Types
Add custom post type registration in `inc/theme-setup.php` or create a separate file in the `inc/` directory.


## Development

### Prerequisites

- WordPress 5.0+
- PHP 7.4+
- Advanced Custom Fields Pro

### Local Development

1. Set up a local WordPress environment
2. Clone this theme to `/wp-content/themes/custom/`
3. Install ACF Pro plugin
4. Activate the theme

### Asset Compilation

For development, edit the source files in `assets/css/` and `assets/js/`. The theme supports both minified and non-minified assets based on the `SCRIPT_DEBUG` constant.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This theme is licensed under the GPL v2 or later.


=======
# custom-theme
This project is a custom WordPress theme developed by Brandon Nyakura as part of an assignment for the Senior Developer role. The theme showcases clean code structure, WordPress best practices.
>>>>>>> 9930fdc0ca39b65f55e17300320ff3f724ab493c
