<tr>
    <td
        colspan="2"
        style="font-family: 'Open Sans', sans-serif;
            background-color: #F5F5F5;
            padding-left: 32px;
            padding-right: 32px;
            padding-bottom: 17px;"
    >
        @if ($subTitle)
            <p
                style="font-style: normal;
                    font-weight: bold;
                    font-size: 16px;
                    line-height: 20px;
                    color: #000000;
                    padding-top: 17px;
                    margin: 0;"
            >
                {{ $subTitle }}
            </p>
        @endif
        <p
            style="font-style: normal;
                font-weight: normal;
                font-size: 14px;
                line-height: 22px;
                margin: 0;
                padding-top: 17px;"
        >
            {!! $text !!}
        </p>
    </td>
</tr>
@if ($buttonUrl && $buttonTitle)
<tr>
    <td
        colspan="2"
        style="background-color: #F5F5F5; padding: 17px 32px 34px;"
    >
        <a
            class="button"
            href="{{ $buttonUrl }}"
            target="_blank"
            style="font-family: 'Open Sans', sans-serif;
            font-style: normal;
            font-weight: normal;
            font-size: 16px;
            line-height: 22px;
            display: flex;
            align-items: center;
            text-align: center;
            color: #FFFFFF;
            padding: 9px 40px;
            background-color: #ED1B24;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;"
        >
            {{ $buttonTitle }}
        </a>
    </td>
</tr>
@endif
