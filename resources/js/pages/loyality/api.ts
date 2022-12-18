import {postData, getData, patchData} from '../../utils/requests';

export const getUploadedReceipts = async () => {
    const response = await getData({
        url: 'api/loyalty/uploaded-receipts'
    });

    // const response = await getOuterData({
    //     url: 'https://testlegweb.free.beeceptor.com/get-list'
    // });
    //console.log('data', response.data)
    if (response.data != undefined && Array.isArray(response.data)) {
        return response.data;
    }
    return [];

};

export const getTotalAmount = async () => {
    const response = await getData({
        url: 'api/loyalty/total-amount'
    });

    // const response = await getOuterData({
    //     url: 'https://testtotalamount.free.beeceptor.com/total-amount'
    // });
    // console.log(response.data);
    // console.log(response.data.amount);
    if (response.data != undefined) {
        if (response.data.amount != undefined)
            return response.data.amount;
    }
    return 0;
};

export const registerVIN = async vin => {
    const response = postData({
        url: 'api/certificate/register',
        params: {code: vin},
    });

    return response;
};

export const getLoyalityList = async () => {
    const response = await postData({url: 'api/loyalty'});
    return response;
};

export const manuallyUploadReceipt = async (data) => {

    const response = await postData({
        url: 'api/loyalty/upload-receipt',
        params: data,
    });

    return response;
}

export const uploadPhotoReceipt = async (files) => {
    console.log("files2: ", files)

    let formData = new FormData();

    for (const receipt of files) {
        console.log("fr: ", receipt)
        formData.append('receipts[]', receipt, receipt.name);
    }

    const response = await postData({
        url: 'api/loyalty/upload-receipt',
        params: formData,
        headers: {
            headers: {
                'Content-Type': 'multipart/form-data',
                Accept: 'application/json',
            },
        },
    });

    return response;
};


export const uploadReceipt = async ({file, loyaltyId}: any) => {
    let formData = new FormData();
    for (const receipt of file) {
        formData.append('receipts[]', receipt, receipt.name);
    }
    formData.append('loyalty_id', loyaltyId);

    const response = await postData({
        url: 'api/loyalty/upload-receipt',
        params: formData,
        headers: {
            headers: {
                'Content-Type': 'multipart/form-data',
                Accept: 'application/json',
            },
        },
    });

    return response;
};

export const getLoyaltyProposals = loyaltyId =>
    getData({
        url: `api/loyalty/${loyaltyId}/proposals`,
    });

export const registerProductCode = async (code, loyaltyId) => {
    const response = postData({
        url: `api/loyalty/register-product-code`,
        params: {code, loyalty_id: loyaltyId},
    });

    return response;
};

export const publishProfile = async ({published, show_contacts}: { published: boolean; show_contacts?: boolean }) => {
    const response = patchData({
        url: 'api/user/profile/published',
        params: {
            show_contacts,
            published,
        },
    });

    return response;
};
