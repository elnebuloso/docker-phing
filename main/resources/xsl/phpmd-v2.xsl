<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" doctype-system="about:legacy-compat"/>

    <xsl:template name="message">
        <xsl:value-of disable-output-escaping="yes" select="."/>
    </xsl:template>

    <xsl:template name="priorityDiv">
        <xsl:if test="@priority = 1">p1</xsl:if>
        <xsl:if test="@priority = 2">p2</xsl:if>
        <xsl:if test="@priority = 3">p3</xsl:if>
        <xsl:if test="@priority = 4">p4</xsl:if>
        <xsl:if test="@priority = 5">p5</xsl:if>
    </xsl:template>

    <xsl:template name="timestamp">
        <xsl:value-of select="substring-before(//pmd/@timestamp, 'T')"/> -
        <xsl:value-of select="substring-before(substring-after(//pmd/@timestamp, 'T'), '.')"/>
    </xsl:template>

    <xsl:template match="pmd">
        <html>
            <head>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

                <title>PHP Mess Detection Report</title>

                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>

                <style type="text/css">
                    .p1 { background: #FF9999; }
                    .p2 { background: #FFCC66; }
                    .p3 { background: #FFFF99; }
                    .p4 { background: #99FF99; }
                    .p5 { background: #9999FF; }
                </style>
            </head>
            <body>
                <section role="headline" class="container-fluid">
                    <h1 class="mt-2">PHP Mess Detection Report</h1>
                </section>


                <br/>
                <section role="summary" class="container-fluid">
                    <h3>Summary</h3>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Files</th>
                                <th>Total</th>
                                <th>Priority 1</th>
                                <th>Priority 2</th>
                                <th>Priority 3</th>
                                <th>Priority 4</th>
                                <th>Priority 5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <xsl:value-of select="count(//file)"/>
                                </td>
                                <td>
                                    <xsl:value-of select="count(//violation)"/>
                                </td>
                                <td class="p1">
                                    <xsl:value-of select="count(//violation[@priority = 1])"/>
                                </td>
                                <td class="p2">
                                    <xsl:value-of select="count(//violation[@priority = 2])"/>
                                </td>
                                <td class="p3">
                                    <xsl:value-of select="count(//violation[@priority = 3])"/>
                                </td>
                                <td class="p4">
                                    <xsl:value-of select="count(//violation[@priority = 4])"/>
                                </td>
                                <td class="p5">
                                    <xsl:value-of select="count(//violation[@priority = 5])"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                <br/>
                <section role="files" class="container-fluid">
                    <h3>Files</h3>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Prio</th>
                                <th>File</th>
                                <th>Line</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="file">
                                <xsl:for-each select="violation">
                                    <tr>
                                        <td>
                                            <xsl:attribute name="class">
                                                <xsl:call-template name="priorityDiv"/>
                                            </xsl:attribute>
                                            <xsl:value-of disable-output-escaping="yes" select="@priority"/>
                                        </td>
                                        <td>
                                            <xsl:value-of disable-output-escaping="yes" select="../@name"/>
                                        </td>
                                        <td>
                                            <xsl:value-of disable-output-escaping="yes" select="@beginline"/>
                                        </td>
                                        <td>
                                            <xsl:if test="@externalInfoUrl">
                                                <a>
                                                    <xsl:attribute name="href">
                                                        <xsl:value-of select="@externalInfoUrl"/>
                                                    </xsl:attribute>
                                                    <xsl:call-template name="message"/>
                                                </a>
                                            </xsl:if>
                                            <xsl:if test="not(@externalInfoUrl)">
                                                <xsl:call-template name="message"/>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                </xsl:for-each>
                            </xsl:for-each>
                        </tbody>
                    </table>
                </section>

                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
