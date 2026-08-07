/* ====================================
   SEO Automator - Dynamic Meta Tag & Schema Generator
   ==================================== */

class SEOAutomator {
    constructor() {
        this.pageData = {};
        this.init();
    }
    
    init() {
        this.extractPageData();
        this.generateMetaTags();
        this.generateStructuredData();
        this.generateBreadcrumbs();
        this.optimizeImages();
    }
    
    // Extract data from page content
    extractPageData() {
        // Get main heading
        const h1 = document.querySelector('h1');
        this.pageData.title = h1 ? h1.textContent.trim() : document.title;
        
        // Get description from first paragraph or meta
        const firstParagraph = document.querySelector('main p, .hero-description');
        const metaDescription = document.querySelector('meta[name="description"]');
        this.pageData.description = metaDescription ? 
            metaDescription.content : 
            (firstParagraph ? this.truncateText(firstParagraph.textContent, 160) : '');
        
        // Get keywords from content
        this.pageData.keywords = this.extractKeywords();
        
        // Get images
        const heroImage = document.querySelector('.hero-visual img, .page-hero img');
        this.pageData.image = heroImage ? heroImage.src : 'https://teznevisan3.com/assets/images/logo.webp';
        
        // Get URL
        this.pageData.url = window.location.href;
        
        // Get page type
        this.pageData.type = this.determinePageType();
        
        // Get author/organization
        this.pageData.author = 'تز نویسان';
        
        // Get modified date
        this.pageData.modified = new Date().toISOString();
    }
    
    // Generate/Update meta tags
    generateMetaTags() {
        // Title
        if (!document.querySelector('meta[property="og:title"]')) {
            this.createMetaTag('property', 'og:title', this.pageData.title);
        }
        
        // Description
        if (!document.querySelector('meta[property="og:description"]')) {
            this.createMetaTag('property', 'og:description', this.pageData.description);
        }
        
        if (!document.querySelector('meta[name="description"]')) {
            this.createMetaTag('name', 'description', this.pageData.description);
        }
        
        // URL
        if (!document.querySelector('meta[property="og:url"]')) {
            this.createMetaTag('property', 'og:url', this.pageData.url);
        }
        
        // Image
        if (!document.querySelector('meta[property="og:image"]')) {
            this.createMetaTag('property', 'og:image', this.pageData.image);
        }
        
        // Type
        if (!document.querySelector('meta[property="og:type"]')) {
            this.createMetaTag('property', 'og:type', this.pageData.type);
        }
        
        // Twitter Card
        if (!document.querySelector('meta[name="twitter:card"]')) {
            this.createMetaTag('name', 'twitter:card', 'summary_large_image');
            this.createMetaTag('name', 'twitter:title', this.pageData.title);
            this.createMetaTag('name', 'twitter:description', this.pageData.description);
            this.createMetaTag('name', 'twitter:image', this.pageData.image);
        }
        
        // Canonical
        if (!document.querySelector('link[rel="canonical"]')) {
            const canonical = document.createElement('link');
            canonical.rel = 'canonical';
            canonical.href = this.pageData.url.split('?')[0]; // Remove query params
            document.head.appendChild(canonical);
        }
    }
    
    // Generate structured data (Schema.org)
    generateStructuredData() {
        const existingSchema = document.querySelector('script[type="application/ld+json"]');
        
        // If no schema exists, create comprehensive one
        if (!existingSchema) {
            const schema = this.createSchemaMarkup();
            const script = document.createElement('script');
            script.type = 'application/ld+json';
            script.text = JSON.stringify(schema, null, 2);
            document.head.appendChild(script);
        }
    }
    
    createSchemaMarkup() {
        const baseSchema = {
            "@context": "https://schema.org",
            "@type": this.getSchemaType(),
            "headline": this.pageData.title,
            "description": this.pageData.description,
            "url": this.pageData.url,
            "image": this.pageData.image,
            "datePublished": this.pageData.modified,
            "dateModified": this.pageData.modified,
            "author": {
                "@type": "Organization",
                "name": "تز نویسان",
                "url": "https://teznevisan3.com",
                "logo": "https://teznevisan3.com/assets/images/logo.webp",
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+98-933-166-3849",
                    "contactType": "Customer Service",
                    "availableLanguage": "Persian",
                    "areaServed": "IR"
                },
                "sameAs": [
                    "https://t.me/Thesissupport",
                    "https://wa.me/+989331663849"
                ]
            },
            "publisher": {
                "@type": "Organization",
                "name": "تز نویسان",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://teznevisan3.com/assets/images/logo.webp"
                }
            }
        };
        
        // Add breadcrumbs
        const breadcrumbSchema = this.generateBreadcrumbSchema();
        
        return {
            "@context": "https://schema.org",
            "@graph": [baseSchema, breadcrumbSchema]
        };
    }
    
    generateBreadcrumbSchema() {
        const breadcrumbList = {
            "@type": "BreadcrumbList",
            "itemListElement": []
        };
        
        const pathParts = window.location.pathname.split('/').filter(part => part);
        let currentPath = 'https://teznevisan3.com';
        
        // Add home
        breadcrumbList.itemListElement.push({
            "@type": "ListItem",
            "position": 1,
            "name": "خانه",
            "item": currentPath
        });
        
        // Add other parts
        pathParts.forEach((part, index) => {
            currentPath += '/' + part;
            breadcrumbList.itemListElement.push({
                "@type": "ListItem",
                "position": index + 2,
                "name": this.formatBreadcrumbName(part),
                "item": currentPath
            });
        });
        
        return breadcrumbList;
    }
    
    generateBreadcrumbs() {
        const breadcrumbElement = document.querySelector('.breadcrumb');
        if (breadcrumbElement && breadcrumbElement.children.length === 0) {
            const pathParts = window.location.pathname.split('/').filter(part => part);
            let currentPath = 'https://teznevisan3.com';
            
            // Add home link
            const homeLink = document.createElement('a');
            homeLink.href = currentPath;
            homeLink.textContent = 'خانه';
            breadcrumbElement.appendChild(homeLink);
            
            pathParts.forEach(part => {
                const separator = document.createElement('span');
                separator.textContent = '/';
                breadcrumbElement.appendChild(separator);
                
                currentPath += '/' + part;
                const link = document.createElement('a');
                link.href = currentPath;
                link.textContent = this.formatBreadcrumbName(part);
                breadcrumbElement.appendChild(link);
            });
        }
    }
    
    optimizeImages() {
        // Add alt text to images without it
        document.querySelectorAll('img:not([alt])').forEach(img => {
            const altText = this.generateAltText(img);
            if (altText) {
                img.alt = altText;
            }
        });
        
        // Add loading="lazy" to images below fold
        document.querySelectorAll('img').forEach((img, index) => {
            if (index > 2 && !img.hasAttribute('loading')) {
                img.loading = 'lazy';
            }
        });
    }
    
    // Helper methods
    createMetaTag(attribute, name, content) {
        const meta = document.createElement('meta');
        meta.setAttribute(attribute, name);
        meta.content = content;
        document.head.appendChild(meta);
    }
    
    truncateText(text, length) {
        text = text.trim().replace(/\s+/g, ' ');
        return text.length > length ? text.substring(0, length) + '...' : text;
    }
    
    extractKeywords() {
        const content = document.body.textContent;
        const h2Tags = Array.from(document.querySelectorAll('h2')).map(h => h.textContent);
        const keywords = [...new Set([...h2Tags, this.pageData.title])];
        return keywords.join(', ');
    }
    
    determinePageType() {
        const path = window.location.pathname;
        if (path.includes('blog') || path.includes('article')) return 'article';
        if (path.includes('services')) return 'Service';
        if (path.includes('about')) return 'AboutPage';
        if (path.includes('contact')) return 'ContactPage';
        return 'WebPage';
    }
    
    getSchemaType() {
        const type = this.determinePageType();
        if (type === 'article') return 'Article';
        if (type === 'Service') return 'Service';
        return 'WebPage';
    }
    
    formatBreadcrumbName(part) {
        return part
            .replace('.html', '')
            .replace(/-/g, ' ')
            .replace(/_/g, ' ')
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }
    
    generateAltText(img) {
        // Try to get alt from nearby text
        const parent = img.closest('figure, .image-container, .service-card, .value-item');
        if (parent) {
            const heading = parent.querySelector('h1, h2, h3, h4');
            if (heading) return heading.textContent.trim();
        }
        
        // Use filename
        const filename = img.src.split('/').pop().split('.')[0];
        return this.formatBreadcrumbName(filename);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    new SEOAutomator();
});
