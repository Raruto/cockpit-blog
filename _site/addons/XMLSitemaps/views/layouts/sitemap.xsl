@<?xml version="1.0" encoding="UTF-8"@?>
  <xsl:stylesheet version="2.0"
    xmlns:html="http://www.w3.org/TR/REC-html40"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <title>XML Sitemap | {{ $app['app.name'] }}</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      @trigger('sitemap.head')
    </head>
    <body>
      <header>
        <a href="@base('/sitemap.xml')"><h1>XML Sitemap</h1></a>
        <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &gt; 0">
          <p>This <b>Sitemap Index</b> contains <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/> sitemaps.</p>
        </xsl:if>
        <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1">
          <p>This <b>Sitemap</b> contains <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URLs.</p>
        </xsl:if>
      </header>
      <main>
        <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &gt; 0">
          <table cellpadding="3">
            <thead>
            <tr>
              <th width="75%">Sitemap</th>
              <th width="25%">Last Modified</th>
            </tr>
            </thead>
            <tbody>
            <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
              <xsl:variable name="sitemapURL">
                <xsl:value-of select="sitemap:loc"/>
              </xsl:variable>
              <tr>
                <td>
                  <a href="{$sitemapURL}"><xsl:value-of select="sitemap:loc"/></a>
                </td>
                <td>
                  <xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)),concat(' ', substring(sitemap:lastmod,20,6)))"/>
                </td>
              </tr>
            </xsl:for-each>
            </tbody>
          </table>
        </xsl:if>
        <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1">
          <table cellpadding="3">
            <thead>
            <tr>
              <th width="75%">URL</th>
              <!-- <th width="5%">Images</th> -->
              <th title="Last Modification Time" width="25%">Last Modified</th>
            </tr>
            </thead>
            <tbody>
            <xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
            <xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
            <xsl:for-each select="sitemap:urlset/sitemap:url">
              <tr>
                <td>
                  <xsl:variable name="itemURL">
                    <xsl:value-of select="sitemap:loc"/>
                  </xsl:variable>
                  <a href="{$itemURL}">
                    <xsl:value-of select="sitemap:loc"/>
                  </a>
                </td>
                <!-- <td>
                  <xsl:value-of select="count(image:image)"/>
                </td> -->
                <td>
                  <xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)),concat(' ', substring(sitemap:lastmod,20,6)))"/>
                </td>
              </tr>
            </xsl:for-each>
            </tbody>
          </table>
        </xsl:if>
      </main>
      @trigger('sitemap.footer')
    </body>
    </html>
  </xsl:template>
  </xsl:stylesheet>
