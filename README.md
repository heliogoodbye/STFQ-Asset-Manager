# STFQ Asset Manager

![STFQ Asset Manager](https://github.com/heliogoodbye/STFQ-Asset-Manager/assets/105381685/93b3593f-4401-43da-92f3-1bf54466b352)

**STFQ Asset Manager** is designed to help WordPress users efficiently manage and distribute digital assets such as AI, EPS, and PDF documents. Let's break down its features and functionalities:

1. **Custom Post Type Registration**: The plugin registers a custom post type called "STFQ Assets" through the `stfq_register_post_type` function. This custom post type allows users to add digital assets with features like title, editor, and thumbnail support.

2. **Custom Taxonomy Registration**: It also registers a custom taxonomy called "Asset Tags" through the `stfq_register_taxonomy` function. This taxonomy enables users to organize and categorize their digital assets based on different tags.

3. **Meta Boxes for Additional Information**: The plugin adds meta boxes for additional information related to digital assets. For instance, it includes meta boxes for managing the download URL (`stfq_download_url_meta_box`) and file type (`stfq_file_type_meta_box`). These meta boxes allow users to input and manage specific details for each asset.

4. **Custom Fields Management**: On plugin activation, it adds a custom field named "Download URL" to existing asset posts. This ensures that each asset has a download URL associated with it. The function `stfq_add_custom_field_on_activation` handles this functionality.

5. **Shortcode for Displaying Assets**: The plugin provides a shortcode `[display_assets]` (`stfq_display_assets_shortcode`) that users can utilize to display their digital assets on any WordPress page or post. Users can specify tags as attributes in the shortcode to filter assets based on specific criteria.

6. **Frontend Styling**: It enqueues a CSS stylesheet (`stfq_enqueue_scripts_styles`) to ensure proper styling of asset display on the frontend. This enhances the visual presentation of digital assets for website visitors.

Overall, the "STFQ Asset Manager" plugin offers a comprehensive solution for managing various types of digital assets within WordPress, providing users with the tools they need to organize, display, and distribute their content effectively.

---

## How to use STFQ Asset Manager

To effectively use the "STFQ Asset Manager" plugin for managing your digital assets within WordPress, follow these step-by-step instructions:

1. **Installation**:
   - Download the "STFQ Asset Manager" plugin.
   - Log in to your WordPress admin dashboard and navigate to `Plugins > Add New`. Click on the "Upload Plugin" button, choose the plugin ZIP file, and click "Install Now."
   - After the installation is complete, activate the plugin from the Plugins page in your WordPress admin dashboard.

2. **Adding Digital Assets**:
   - Once the plugin is activated, you can start adding digital assets.
   - Go to "Assets" > "Add New" in your WordPress admin dashboard.
   - Enter a title for your asset.
   - Add content or description related to the asset in the editor.
   - Set a featured image (thumbnail) for the asset.
   - Specify the file type of the asset using the "File Type" meta box.
   - Enter the download URL for the asset in the "Download URL" meta box.
   - Optionally, assign tags to categorize your assets using the "Asset Tags" taxonomy.

3. **Displaying Assets**:
   - To display your digital assets on your WordPress site, you can use the provided shortcode `[display_assets]`.
   - Insert the shortcode into any post, page, or widget where you want the assets to appear.
   - Optionally, you can specify tags as attributes in the shortcode to filter assets based on specific criteria. For example: `[display_assets tags="tag1, tag2"]`.

4. **Managing Assets**:
   - You can edit or delete existing assets by going to "Assets" > "All Assets" in your WordPress admin dashboard.
   - From the asset list, you can edit individual assets to update their details or delete assets that are no longer needed.

5. **Customization**:
   - If you need to customize the plugin further, you can modify the plugin files or add custom code snippets to achieve specific functionalities.
   - Be cautious while making changes and ensure you have a backup of your website in case anything goes wrong.

6. **Styling**:
   - The plugin comes with default styling, but you can customize the appearance of your assets by modifying the CSS styles.
   - You can do this by adding custom CSS code to your theme's stylesheet or using a custom CSS plugin.

By following these instructions, you can effectively utilize the "STFQ Asset Manager" plugin to manage and showcase your digital assets on your WordPress website.

---

## Disclaimer

This WordPress plugin is provided without warranty. As the program is licensed free of charge, there is no warranty for the program, to the extent permitted by applicable law. The entire risk as to the quality and performance of the program is with you. Should the program prove defective, you assume the cost of all necessary servicing, repair, or correction.

In no event unless required by applicable law or agreed to in writing will the authors or copyright holders be liable to you for damages, including any general, special, incidental, or consequential damages arising out of the use or inability to use the program (including but not limited to loss of data or data being rendered inaccurate or losses sustained by you or third parties or a failure of the program to operate with any other programs), even if such holder or other party has been advised of the possibility of such damages.
