<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" doctype-system="about:legacy-compat"/>

    <xsl:template match="pmd-cpd">
        <html>
            <head>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

                <title>PHP Copy and Paste Detection</title>

                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>

                <style>
                    .code-fragment { font-size: 0.9em; }
                    .table-borderless td, .table-borderless th { border: none; }
                    .table-stripeless { background: none!important; }
                    .table-stripeless td, .table-stripeless tr, .table-stripeless th { background: none!important; }
                </style>
            </head>
            <body>
                <section role="headline" class="container-fluid">
                    <h1 class="mt-2">PHP Copy and Paste Detection</h1>
                </section>


                <br/>
                <section role="summary" class="container-fluid">
                    <h3>Summary of duplicated code</h3>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"># Duplications</th>
                                <th scope="col">Total lines</th>
                                <th scope="col">Total tokens</th>
                                <th scope="col">Approx. # Bytes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <xsl:value-of select="count(//duplication[@lines])"/>
                                </td>
                                <td>
                                    <xsl:value-of select="sum(//duplication[@lines]/@lines)"/>
                                </td>
                                <td>
                                    <xsl:value-of select="sum(//duplication[@lines]/@tokens)"/>
                                </td>
                                <td>
                                    <xsl:value-of select="sum(//duplication[@lines]/@tokens) * 4"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                <br/>
                <section role="list" class="container-fluid">
                    <h3>Duplicated Files and Lines</h3>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Files</th>
                                <th scope="col"># Lines</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="//duplication[@lines]">
                                <xsl:sort data-type="number" order="descending" select="@lines"/>
                                <tr>
                                    <td>
                                        <xsl:value-of select="position()"/>
                                    </td>
                                    <td>
                                        <table class="table table-sm table-borderless table-stripeless">
                                            <tbody>
                                                <xsl:for-each select="file">
                                                    <tr>
                                                        <td>
                                                            <a>
                                                                <xsl:value-of select="@path"/>
                                                            </a>
                                                        </td>
                                                        <td>line
                                                            <xsl:value-of select="@line"/>
                                                        </td>
                                                    </tr>
                                                </xsl:for-each>
                                            </tbody>
                                        </table>

                                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <xsl:attribute name="id">modal-<xsl:value-of select="position()"/>
                                            </xsl:attribute>
                                            <xsl:attribute name="aria-labelledby">codefragmentModal<xsl:value-of select="position()"/>
                                            </xsl:attribute>

                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Duplicate Lines</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <textarea class="form-control code-fragment" rows="20" wrap="off">
                                                                <xsl:value-of select="codefragment"/>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <xsl:value-of select="@lines"/>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal">
                                            <xsl:attribute name="data-target">#modal-<xsl:value-of select="position()"/>
                                            </xsl:attribute>
                                            show duplicate lines
                                        </button>
                                    </td>
                                </tr>
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
