import * as React from 'react';
import * as Recaptcha from 'react-recaptcha';

interface ICaptcha {
    sitekey?: string;
    onVerify: (token: string) => void;
}

const Captcha = ({ sitekey = '', onVerify }: ICaptcha) => {
    return <Recaptcha sitekey={sitekey} render="explicit" verifyCallback={onVerify} />;
};

export default Captcha;
