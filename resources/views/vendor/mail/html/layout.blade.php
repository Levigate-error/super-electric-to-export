<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    </head>
    <body>
        <style>
            @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700,800&display=swap");

            .link:hover {
                color: #c10c14 !important;
            }

            .button:hover {
                background-color: #c10c14 !important;
            }
        </style>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td
                        align="center"
                        valign="top"
                        bgcolor="#FFFFFF"
                        style="background-color:#FFFFFF;"
                    >
                        <table width="600" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                {{ $header ?? '' }}

                                {{ Illuminate\Mail\Markdown::parse($slot) }}

                                {{ $footer ?? '' }}
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
