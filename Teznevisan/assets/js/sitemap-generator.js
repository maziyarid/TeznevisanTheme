/* ====================================
   Sitemap Generator
   ==================================== */

class SitemapGenerator {
    constructor() {
        this.pages = [];
        this.init();
    }
    
    init() {
        // In production, this would scan your server
        // For static sites, you define pages manually or use a build tool
        this.definePages();
        this.generateSitemap();
        this.generateRobotsTxt();
    }
    
    definePages() {
        // Main pages
        this.addPage('/', 1.0, 'daily');
        this.addPage('/about.html', 0.8, 'monthly');
        this.addPage('/services.html', 0.9, 'weekly');
        this.addPage('/contact.html', 0.7, 'monthly');
        this.addPage('/inquiry.html', 0.9, 'weekly');
        
        // Service pages
        const services = [
            'thesis-writing', 'proposal-writing', 'article-writing',
            'statistical-analysis', 'translation', 'programming'
        ];
        services.forEach(service => {
            this.addPage(`/${service}.html`, 0.85, 'weekly');
        });
        
        // Other pages
        this.addPage('/pricing.html', 0.8, 'monthly');
        this.addPage('/portfolio.html', 0.7, 'weekly');
        this.addPage('/blog.html', 0.8, 'daily');
        this.addPage('/faq.html', 0.7, 'monthly');
    }
    
    addPage(url, priority, changefreq) {
        this.pages.push({
            loc: `https://teznevisan3.com${url}`,
            lastmod: new Date().toISOString().split('T')[0],
            priority: priority,
            changefreq: changefreq
        });
    }
    
    generateSitemap() {
        const xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${this.pages.map(page => `  <url>
    <loc>${page.loc}</loc>
    <lastmod>${page.lastmod}</lastmod>
    <changefreq>${page.changefreq}</changefreq>
    <priority>${page.priority}</priority>
  </url>`).join('\n')}
</urlset>`;
        
        console.log('Generated Sitemap XML:');
        console.log(xml);
        
        // Download sitemap
        this.downloadFile('sitemap.xml', xml, 'application/xml');
    }
    
    generateRobotsTxt() {
        const robotsTxt = `User-agent: *
Allow: /

Sitemap: https://teznevisan3.com/sitemap.xml

# Disallow certain paths if needed
Disallow: /assets/
Disallow: /temp/`;
        
        console.log('Generated robots.txt:');
        console.log(robotsTxt);
        
        this.downloadFile('robots.txt', robotsTxt, 'text/plain');
    }
    
    downloadFile(filename, content, mimeType) {
        const blob = new Blob([content], { type: mimeType });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
}

// To generate sitemap, call this in browser console:
// new SitemapGenerator();
