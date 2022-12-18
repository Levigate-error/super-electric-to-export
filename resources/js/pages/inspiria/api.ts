import {postData, getData, patchData} from '../../utils/requests';

export const getUploadedReceipts = async (page = 1, limit = 10) => {
    const response = await getData({
        url: `api/loyalty/user-coupons?page=${page}&limit=${limit}`
    });
    if (response?.data?.data) {
        return response.data.data;
    }
    return [];
};

export const getUploadedGifts= async () => {
  const response = await getData({
    url: `/api/loyalty/gifts`
  });
  if (response?.data?.data) {
    return response.data.data;
  }
  return [];
};

export const getTotalAmount = async () => {
    const response = await getData({
        url: 'api/loyalty/total-amount'
    });
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

export const manuallyUploadReceipt = async (data, currentReceipt) => {
    if (!currentReceipt) return null
    return await postData({
        url: 'api/loyalty/manually-upload-receipt',
        params: {
            ...data,
            receipt_datetime: data.receipt_datetime ? `${
                data.receipt_datetime.slice(8, 10)
            }.${
                data.receipt_datetime.slice(5, 7)
            }.${
                data.receipt_datetime.slice(2, 4)
            } ${
                data.receipt_datetime.slice(11, 16)
            }` : null,
            coupon_code: currentReceipt.coupon_code
        },
    });
}

export const uploadPhotoReceipt = async (files, currentReceipt) => {
    if (files?.length < 1 || !currentReceipt) return null

    let formData = new FormData();

    const receipt = files[0]
    formData.append('receipts[]', receipt, receipt.name);

    formData.append('coupon_code', currentReceipt.coupon_code);

    return await postData({
        url: 'api/loyalty/upload-receipt',
        params: formData,
        headers: {
            headers: {
                'Content-Type': 'multipart/form-data',
                Accept: 'application/json',
            },
        },
    });
};

export const choseGift = async (id)=>{
    const response = postData({
        url: `api/loyalty/choose-gift`,
        params: {id: id},
    });

    return response;
}

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

export const registerPromocode = async (code) => {
    return new Promise((resolve, reject) => {
        getData({
            url: `api/loyalty/add-coupon?code=${code}`
        })
            .then(res => {
                if (res.status === 200)
                    resolve(res)
                reject(res)
            })
            .catch(e => {
                reject(e)
            })
    })
}

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
