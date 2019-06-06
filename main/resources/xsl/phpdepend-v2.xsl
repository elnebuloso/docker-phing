<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" doctype-system="about:legacy-compat"/>

    <xsl:template match="PDepend">
        <html>
            <head>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

                <title>PHP Software metrics - PHPDepend Analysis</title>

                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
            </head>
            <body>
                <section role="headline" class="container-fluid">
                    <h1 class="mt-2">PHP Software metrics - PHPDepend Analysis</h1>
                </section>


                <br/>
                <section role="images" class="container-fluid">
                    <div class="clearfix">
                        <img src="./assets/chart.svg" class="rounded float-left img-fluid img-thumbnail" alt="Responsive image"/>
                        <img src="./assets/pyramid.svg" class="rounded float-right img-fluid img-thumbnail" alt="Responsive image"/>
                    </div>
                </section>


                <br/>
                <section role="summary" class="container-fluid">
                    <h3>Summary</h3>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Package</th>
                                <th>Total Classes</th>
                                <th>Abstract Classes</th>
                                <th>Concrete Classes</th>
                                <th>Afferent Couplings</th>
                                <th>Efferent Couplings</th>
                                <th>Abstractness</th>
                                <th>Instability</th>
                                <th>Distance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="./Packages/Package">
                                <xsl:if test="count(error) = 0">
                                    <tr>
                                        <td align="left">
                                            <a>
                                                <xsl:attribute name="href">#PK<xsl:value-of select="@name"/>
                                                </xsl:attribute>
                                                <xsl:value-of select="@name"/>
                                            </a>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/TotalClasses"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/AbstractClasses"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/ConcreteClasses"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/Ca"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/Ce"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/A"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/I"/>
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="Stats/D"/>
                                        </td>
                                    </tr>
                                </xsl:if>
                            </xsl:for-each>
                            <xsl:for-each select="./Packages/Package">
                                <xsl:if test="count(error) &gt; 0">
                                    <tr>
                                        <td align="left">
                                            <xsl:value-of select="@name"/>
                                        </td>
                                        <td align="left" colspan="8">
                                            <xsl:value-of select="error"/>
                                        </td>
                                    </tr>
                                </xsl:if>
                            </xsl:for-each>
                        </tbody>
                    </table>
                </section>


                <br/>
                <section role="packages" class="container-fluid">
                    <h3>Packages</h3>
                    <xsl:for-each select="./Packages/Package">
                        <xsl:if test="count(error) = 0">
                            <br/>
                            <h4>
                                <a>
                                    <xsl:attribute name="name">PK<xsl:value-of select="@name"/>
                                    </xsl:attribute>
                                    <xsl:value-of select="@name"/>
                                </a>
                            </h4>

                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td valign="top" width="20%"><a href="#EXafferent">Afferent Couplings</a>:
                                            <xsl:value-of select="Stats/Ca"/>
                                        </td>
                                        <td valign="top" width="20%"><a href="#EXefferent">Efferent Couplings</a>:
                                            <xsl:value-of select="Stats/Ce"/>
                                        </td>
                                        <td valign="top" width="20%"><a href="#EXabstractness">Abstractness</a>:
                                            <xsl:value-of select="Stats/A"/>
                                        </td>
                                        <td valign="top" width="20%"><a href="#EXinstability">Instability</a>:
                                            <xsl:value-of select="Stats/I"/>
                                        </td>
                                        <td valign="top" width="20%"><a href="#EXdistance">Distance</a>:
                                            <xsl:value-of select="Stats/D"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Abstract Classes</th>
                                        <th>Concrete Classes</th>
                                        <th>Used by Packages</th>
                                        <th>Uses Packages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td valign="top" width="25%">
                                            <xsl:if test="count(AbstractClasses/Class)=0">
                                                <i>None</i>
                                            </xsl:if>
                                            <xsl:for-each select="AbstractClasses/Class">
                                                <xsl:value-of select="node()"/>
                                                <br/>
                                            </xsl:for-each>
                                        </td>
                                        <td valign="top" width="25%">
                                            <xsl:if test="count(ConcreteClasses/Class)=0">
                                                <i>None</i>
                                            </xsl:if>
                                            <xsl:for-each select="ConcreteClasses/Class">
                                                <xsl:value-of select="node()"/>
                                                <br/>
                                            </xsl:for-each>
                                        </td>
                                        <td valign="top" width="25%">
                                            <xsl:if test="count(UsedBy/Package)=0">
                                                <i>None</i>
                                            </xsl:if>
                                            <xsl:for-each select="UsedBy/Package">
                                                <a>
                                                    <xsl:attribute name="href">#PK<xsl:value-of select="node()"/>
                                                    </xsl:attribute>
                                                    <xsl:value-of select="node()"/>
                                                </a>
                                                <br/>
                                            </xsl:for-each>
                                        </td>
                                        <td valign="top" width="25%">
                                            <xsl:if test="count(DependsUpon/Package)=0">
                                                <i>None</i>
                                            </xsl:if>
                                            <xsl:for-each select="DependsUpon/Package">
                                                <a>
                                                    <xsl:attribute name="href">#PK<xsl:value-of select="node()"/>
                                                    </xsl:attribute>
                                                    <xsl:value-of select="node()"/>
                                                </a>
                                                <br/>
                                            </xsl:for-each>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </xsl:if>
                    </xsl:for-each>
                </section>


                <br/>
                <section role="packages" class="container-fluid">
                    <h3>Cycles</h3>
                    <xsl:if test="count(Cycles/Package) = 0">
                        <p>There are no cyclic dependancies.</p>
                    </xsl:if>
                    <xsl:for-each select="Cycles/Package">
                        <h3>
                            <xsl:value-of select="@Name"/>
                        </h3>
                        <p>
                            <xsl:for-each select="Package">
                                <xsl:value-of select="."/>
                                <br/>
                            </xsl:for-each>
                        </p>
                    </xsl:for-each>
                </section>


                <br/>
                <section role="explanation" class="container-fluid">
                    <h3>Explanations</h3>
                    <p>
                        The following explanations are for quick reference and are lifted directly from the original <a href="http://www.clarkware.com/software/JDepend.html">JDepend documentation</a>.
                    </p>

                    <h5>
                        <a name="EXnumber">Number of Classes</a>
                    </h5>
                    <p>The number of concrete and abstract classes (and interfaces) in the package is an indicator of the extensibility of the package.</p>
                    <h5>
                        <a name="EXafferent">Afferent Couplings</a>
                    </h5>
                    <p>The number of other packages that depend upon classes within the package is an indicator of the package's responsibility.</p>
                    <h5>
                        <a name="EXefferent">Efferent Couplings</a>
                    </h5>
                    <p>The number of other packages that the classes in the package depend upon is an indicator of the package's independence.</p>
                    <h5>
                        <a name="EXabstractness">Abstractness</a>
                    </h5>
                    <p>The ratio of the number of abstract classes (and interfaces) in the analyzed package to the total number of classes in the analyzed package.</p>
                    <p>The range for this metric is 0 to 1, with A=0 indicating a completely concrete package and A=1 indicating a completely abstract package.</p>
                    <h5>
                        <a name="EXinstability">Instability</a>
                    </h5>
                    <p>The ratio of efferent coupling (Ce) to total coupling (Ce / (Ce + Ca)). This metric is an indicator of the package's resilience to change.</p>
                    <p>The range for this metric is 0 to 1, with I=0 indicating a completely stable package and I=1 indicating a completely instable package.</p>
                    <h5>
                        <a name="EXdistance">Distance</a>
                    </h5>
                    <p>The perpendicular distance of a package from the idealized line A + I = 1. This metric is an indicator of the package's balance between abstractness and stability.</p>
                    <p>A package squarely on the main sequence is optimally balanced with respect to its abstractness and stability. Ideal packages are either completely abstract and stable (x=0, y=1) or completely concrete and instable (x=1, y=0).</p>
                    <p>The range for this metric is 0 to 1, with D=0 indicating a package that is coincident with the main sequence and D=1 indicating a package that is as far from the main sequence as possible.</p>
                </section>


                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
