# WooCommerce Fix: Invalid Parent Category in Child Category URL (404 Handling)

WooCommerce, by default, allows child category pages to be displayed even when the parent category in the URL is incorrect. This can lead to SEO issues, where search engines may index invalid URLs, resulting in duplicated or irrelevant content. To resolve this issue, this code ensures that WooCommerce will return a `404 Not Found` error when an invalid parent category is included in the URL.

## Problem

In WooCommerce, product categories are often structured in a hierarchical way, such as:

`http://yoursite.com/product-category/parent-category/child-category/`

However, WooCommerce does not validate the parent-child relationship in URLs. If the parent category part of the URL is changed to an incorrect value, WooCommerce still serves the child category page. For example:

`http://yoursite.com/product-category/invalid-parent/child-category/`

Even though the parent category is invalid, WooCommerce will still display the child category page, resulting in an incorrect `200 OK` status. This creates issues for SEO as search engines may index URLs that don’t reflect the actual category hierarchy, diluting your site's SEO performance with irrelevant or incorrect URLs.

## Solution

This code checks the full category URL structure, ensuring that the parent category in the URL matches the actual parent of the child category. If the parent category is incorrect, the code triggers a proper `404 Not Found` error, preventing WooCommerce from serving the child category page under an incorrect parent.

### Key Features:
- **Parent-Child Category Validation**: Ensures the URL structure reflects the actual category hierarchy.
- **404 Error Handling**: Triggers a 404 error for incorrect parent category URLs, preventing invalid URLs from being served.
- **SEO Improvement**: Reduces the risk of incorrect URLs being indexed by search engines, helping maintain a clean and accurate URL structure for WooCommerce product categories.
- **Works on Localhost and Live Sites**: Whether you're developing on localhost or running a live site, this solution works consistently.

## Use Cases

1. **Incorrect Parent Category in URL**:  
   If a user or search engine tries to access a child category with an incorrect parent category in the URL, such as:
    http://yoursite.com/product-category/wrong-parent/child-category/
The code will trigger a 404 error, ensuring that only valid URLs are served.

2. **SEO Crawling & Indexing**:  
By preventing the serving of incorrect category URLs, this solution helps maintain a cleaner, more accurate URL structure for search engines to crawl, ultimately improving the SEO of your WooCommerce site.
