/* ====================================
   Dynamic SEO Manager (WordPress-style)
   ==================================== */

class SEOManager {
    constructor() {
        this.siteName = 'تزنویسان';
        this.separator = '|';
        this.defaultDescription = 'موسسه تزنویسان با بیش از ۱۰ سال تجربه، ارائه دهنده خدمات تخصصی انجام پایان نامه، مقاله، پروپوزال و پروژه های پژوهشی';
        this.baseUrl = 'https://teznevisan3.com';
        this.init();
    }

    init() {
        this.generateTitle();
        this.generateMetaTags();
        this.generateSchema();
        this.generateBreadcrumbs();
        this.optimizeImages();
    }

    // Auto-generate title: "Page Name | تزنویسان"
    generateTitle() {
        const h1 = document.querySelector('h1');
        if (h1) {
            const pageName = h1.textContent.trim();
            const fullTitle = `${pageName} ${this.separator} ${this.siteName}`;
            document.title = fullTitle;
            
            // Update OG title
            this.updateMetaTag('property', 'og:title', fullTitle);
            this.updateMetaTag('name', 'twitter:title', fullTitle);
        }
    }

    generateMetaTags() {
        const description = this.extractDescription();
        const keywords = this.extractKeywords();
        const image = this.extractImage();
        const url = window.location.href;

        // Description
        this.updateMetaTag('name', 'description', description);
        this.updateMetaTag('property', 'og:description', description);
        this.updateMetaTag('name', 'twitter:description', description);

        // Keywords
        this.updateMetaTag('name', 'keywords', keywords);

        // Image
        this.updateMetaTag('property', 'og:image', image);
        this.updateMetaTag('name', 'twitter:image', image);

        // URL
        this.updateMetaTag('property', 'og:url', url);
        
        // Canonical
        this.updateCanonical(url);

        // Author
        this.updateMetaTag('name', 'author', this.siteName);

        // Robots
        this.updateMetaTag('name', 'robots', 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1');
    }

    extractDescription() {
        // Try existing meta
        const existing = document.querySelector('meta[name="description"]');
        if (existing && existing.content) return existing.content;

        // Extract from first paragraph
        const firstP = document.querySelector('main p, .hero-description');
        if (firstP) {
            return this.truncate(firstP.textContent, 160);
        }

        return this.defaultDescription;
    }

    extractKeywords() {
        // Get from h2 tags and page title
        const h2s = Array.from(document.querySelectorAll('h2')).map(h => h.textContent);
        const h1 = document.querySelector('h1')?.textContent || '';
        const keywords = [h1, ...h2s, this.siteName].join(', ');
        return this.truncate(keywords, 200);
    }

    extractImage() {
        // Try to find page hero image
        const heroImg = document.querySelector('.hero-visual img, .page-hero img, main img');
        if (heroImg) return heroImg.src;
        
        return `${this.baseUrl}/assets/images/logo.webp`;
    }

    generateSchema() {
        const schema = {
            "@context": "https://schema.org",
            "@graph": [
                this.createWebPageSchema(),
                this.createOrganizationSchema(),
                this.createBreadcrumbSchema()
            ]
        };

        // Add to page if not exists
        if (!document.querySelector('script[type="application/ld+json"]')) {
            const script = document.createElement('script');
            script.type = 'application/ld+json';
            script.text = JSON.stringify(schema, null, 2);
            document.head.appendChild(script);
        }
    }

    createWebPageSchema() {
        return {
            "@type": "WebPage",
            "@id": window.location.href + "#webpage",
            "url": window.location.href,
            "name": document.title,
            "description": this.extractDescription(),
            "datePublished": new Date().toISOString(),
            "dateModified": new Date().toISOString(),
            "inLanguage": "fa-IR",
            "isPartOf": {
                "@id": this.baseUrl + "#website"
            }
        };
    }

    createOrganizationSchema() {
        return {
            "@type": "Organization",
            "@id": this.baseUrl + "#organization",
            "name": this.siteName,
            "url": this.baseUrl,
            "logo": {
                "@type": "ImageObject",
                "url": `${this.baseUrl}/assets/images/logo.webp`,
                "width": 250,
                "height": 65
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+98-933-166-3849",
                "contactType": "Customer Service",
                "availableLanguage": ["Persian"],
                "areaServed": "IR"
            },
            "sameAs": [
                "https://t.me/Thesissupport",
                "https://wa.me/+989331663849",
                "https://eitaa.com/Teznevs"
            ]
        };
    }

    createBreadcrumbSchema() {
        const breadcrumbList = {
            "@type": "BreadcrumbList",
            "@id": window.location.href + "#breadcrumb",
            "itemListElement": []
        };

        const pathParts = window.location.pathname.split('/').filter(p => p);
        let currentPath = this.baseUrl;

        // Add home
        breadcrumbList.itemListElement.push({
            "@type": "ListItem",
            "position": 1,
            "name": "خانه",
            "item": currentPath
        });

        // Add path parts
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
        const breadcrumbEl = document.querySelector('.breadcrumb');
        if (breadcrumbEl && breadcrumbEl.children.length === 0) {
            const pathParts = window.location.pathname.split('/').filter(p => p);
            let currentPath = this.baseUrl;

            // Home link
            const homeLink = document.createElement('a');
            homeLink.href = currentPath;
            homeLink.textContent = 'خانه';
            breadcrumbEl.appendChild(homeLink);

            pathParts.forEach(part => {
                const separator = document.createElement('span');
                separator.textContent = '/';
                breadcrumbEl.appendChild(separator);

                currentPath += '/' + part;
                const link = document.createElement('a');
                link.href = currentPath;
                link.textContent = this.formatBreadcrumbName(part);
                breadcrumbEl.appendChild(link);
            });
        }
    }

    optimizeImages() {
        document.querySelectorAll('img:not([alt])').forEach(img => {
            const altText = this.generateAltText(img);
            if (altText) img.alt = altText;
        });

        // Add loading="lazy" to below-fold images
        document.querySelectorAll('img').forEach((img, index) => {
            if (index > 2 && !img.hasAttribute('loading')) {
                img.loading = 'lazy';
            }
        });

        // Add fetchpriority="high" to LCP image
        const lcpImage = document.querySelector('.hero-visual img, .page-hero img');
        if (lcpImage) {
            lcpImage.fetchPriority = 'high';
            lcpImage.loading = 'eager';
        }
    }

    // Helper methods
    updateMetaTag(attr, name, content) {
        let tag = document.querySelector(`meta[${attr}="${name}"]`);
        if (!tag) {
            tag = document.createElement('meta');
            tag.setAttribute(attr, name);
            document.head.appendChild(tag);
        }
        tag.content = content;
    }

    updateCanonical(url) {
        let canonical = document.querySelector('link[rel="canonical"]');
        if (!canonical) {
            canonical = document.createElement('link');
            canonical.rel = 'canonical';
            document.head.appendChild(canonical);
        }
        canonical.href = url.split('?')[0];
    }

    truncate(text, length) {
        text = text.trim().replace(/\s+/g, ' ');
        return text.length > length ? text.substring(0, length) + '...' : text;
    }

    formatBreadcrumbName(part) {
        return part
            .replace('.html', '')
            .replace(/-/g, ' ')
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    generateAltText(img) {
        const parent = img.closest('figure, .service-card, .value-item');
        if (parent) {
            const heading = parent.querySelector('h1, h2, h3, h4');
            if (heading) return heading.textContent.trim();
        }
        
        const filename = img.src.split('/').pop().split('.')[0];
        return this.formatBreadcrumbName(filename);
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new SEOManager());
} else {
    new SEOManager();
}
