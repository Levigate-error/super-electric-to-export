import * as React from 'react';
import {useCallback, useEffect, useState} from 'react';
import PageLayout from '../../components/PageLayout';
import Button from '../../ui/Button';
import Input from '../../ui/Input';
import Modal from '../../ui/Modal';
import PopUp from "../../ui/PopUp";
import Method from './components/Modal/Method';
import Manual from './components/Modal/Manual';
import Check from './components/Modal/Check';
import PrizeConfirm from './components/Modal/PrizeConfirm';
import PrizeCheck from './components/Modal/PrizeCheck';
import PersonalInfo from './components/Modal/PersonalInfo';
import {getTotalAmount, getUploadedGifts, getUploadedReceipts, registerPromocode} from './api';
import PromocodeRegistered from "./components/PromocodeRegistered";
// import {PRIZES} from '../../constants/inspiriaPrizes';

const Loyalty = () => {

  const [modalState, setModalState] = React.useState('method');
  const [modalIsOpen, setModalIsOpen] = React.useState(false);
  const [popUplIsOpen, setPopUplIsOpen] = React.useState(false);

  const [prizeNumber, setPrizeNumber] = React.useState(0);
  const [prizePoints, setPrizePoints] = React.useState(0);
  const [prizeName, setPrizeName] = React.useState('');
  const [currentPoints, setCurrentPoints] = React.useState(0);

  const [uploadedReceipts, setUploadedReceipts] = React.useState([]);
  const [uploadedGifts, setUploadedGifts] = React.useState([]);
  const [promocodesPage, setPromocodesPage] = useState<number>(1);
  const [promocodesPerPage] = useState<number>(3);
  const [totalPromocodes, setTotalPromocodes] = useState<number>(0);
  const [uploadedReceiptsStatus, setUploadedReceiptsStatus] = React.useState(false);



  React.useEffect(() => {
    getTotalAmount().then(amount => {
      setCurrentPoints(amount)
    });
    getUploadedReceipts(promocodesPage, promocodesPerPage).then(response => {
      setUploadedReceiptsStatus(true)
      setUploadedReceipts(response.coupons || []);
      setTotalPromocodes(response.total_count || 0);
    });

    getUploadedGifts().then(response=>{
      setUploadedGifts(response);
    });

  }, []);

  const togglePopUp = () => {
    setPopUplIsOpen(!popUplIsOpen);
  };

  const [currentReceipt, setCurrentReceipt] = useState(null)
  const toggleModal = (receipt) => {
    setModalIsOpen(!modalIsOpen);
    setModalState('method');
    setCurrentReceipt(receipt || null)
  };

  useEffect(() => {
    if (!modalIsOpen) {
      setCurrentReceipt(null)
    }
  }, [modalIsOpen])

  useEffect(() => {
    if (modalState === 'check') {
      setPromocodesPage(1)
      setTotalPromocodes(0)
      setUploadedReceiptsStatus(false)
      getUploadedReceipts(1, promocodesPerPage)
        .then(res => {
          setUploadedReceiptsStatus(true)
          setUploadedReceipts(res.coupons || [])
          setTotalPromocodes(res.total_count || 0)
        })
    }
  }, [modalState])

const GiftList = props =>{

    return props.gifts.map((gift, index) => {
      return        <div key={gift.id}
                         className={"loyalty__showcase__item " + (currentPoints >= gift.point ? 'loyalty__showcase__item--avaliable ' : ' ') + (gift.completed == true ? 'loyalty__showcase__item--disorder ' : ' ')}>
        <div className="loyalty__showcase__item--image">
          <img src={`${gift.image_url}`} alt=""
               className="promo-collection__img"/>
        </div>
        <h4>{gift.title}</h4>
        <p>{gift.point} баллов</p>

        <button onClick={() => toggleModalGift(gift)}
                className="loyalty__showcase__item--button">Выбрать
        </button>
        {!!gift.description && (
          <div className="loyalty__showcase__item--help">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path fillRule="evenodd" clipRule="evenodd"
                    d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z"
                    fill="#E60012"/>
            </svg>
            <p dangerouslySetInnerHTML={{__html: gift.description}}/>
          </div>
        )}
      </div>
    });
}

  const RecieptList = props => {

    if (!uploadedReceiptsStatus) {
      return (
        <tr>
          <td>
            Идет загрузка промокодов
          </td>
        </tr>
      )
    }

    if (!props.reciepts || props.reciepts.length === 0) {
      return (
        <tr>
          <td>
            Пока нет промокодов. Добавьте их.
          </td>
        </tr>
      )
    }

    return props.reciepts.map((reciept, index) => {
      const points = reciept.points_already_accured !== null ? reciept.points_already_accured : '-'
      const receipt_datetime = reciept.created_at !== null ? reciept.created_at : '-'
      let receipt_status_text
      switch (reciept.review_status_id) {
        case 1:
          receipt_status_text = 'Загрузите чек'
          break
        case 2:
          receipt_status_text = 'Одобрено'
          break
        case 3:
          receipt_status_text = 'Отклонено'
          break
        default:
          receipt_status_text = 'На проверке'
      }
      return <tr key={`reciept_${index}`}>
        <td>{reciept.coupon_code}</td>
        <td>{receipt_datetime}</td>
        <td>{points}</td>
        <td>
          <div
            className={`loyalty__status loyalty__status--${reciept.review_status_id}`}
            onClick={reciept.review_status_id === 1 && !promocodeLoading && !loadingMorePromocodes ? () => toggleModal(reciept) : null}
          >
            {receipt_status_text}
          </div>
        </td>
      </tr>
    })
  }
  // const toggleModalPrize = (prize) => {
  //   setPrizeNumber(prize.id);
  //   setPrizePoints(prize.price);
  //   setPrizeName(prize.name)
  //
  //   setModalIsOpen(!modalIsOpen);
  //   setModalState('prize-confirm');
  // };

  const toggleModalGift = (gift) => {
    setPrizeNumber(gift.id);
    setPrizePoints(gift.point);
    setPrizeName(gift.title)

    setModalIsOpen(!modalIsOpen);
    setModalState('prize-confirm');
  };


  const [promocode, setPromocode] = useState<string>('');
  const [promocodeError, setPromocodeError] = useState<boolean>(false);
  const [promocodeLoading, setPromocodeLoading] = useState<boolean>(false);

  const onRegisterPromocode = useCallback(async () => {
    setPromocodeLoading(true)
    setPromocodeError(false)
    await registerPromocode(promocode)
      .then(async () => {
        await getUploadedReceipts(1, promocodesPerPage)
          .then(res => {
            setModalIsOpen(true)
            setModalState('promocode-registered')
            setPromocode('')
            setPromocodesPage(1)
            setTotalPromocodes(0)
            setUploadedReceiptsStatus(false)
            setUploadedReceiptsStatus(true)
            setUploadedReceipts(res.coupons || [])
            setTotalPromocodes(res.total_count || 0)
          })
      })
      .catch(() => {
        setPromocodeError(true)
      })
    setPromocodeLoading(false)
  }, [promocode, promocodesPerPage])

  const [loadingMorePromocodes, setLoadingMorePromocodes] = useState<boolean>(false);

  const onLoadMorePromocodes = useCallback(async () => {
    setPromocodesPage(promocodesPage + 1)
    setLoadingMorePromocodes(true)

    await getUploadedReceipts(promocodesPage + 1, promocodesPerPage)
      .then(res => {
        setUploadedReceipts([...uploadedReceipts, ...(res.coupons || [])])
      })

    setLoadingMorePromocodes(false)
  }, [promocodesPage, promocodesPerPage, uploadedReceipts])

  const onClosePromocodeRegistered = useCallback((providedPromocode) => {
    setCurrentReceipt({coupon_code: providedPromocode})
    setModalState('method')
  }, [])

  // @ts-ignore
  return (
    <div className="loayality container mt-5 mb-5">



      <PopUp isOpen={popUplIsOpen} onClose={() => togglePopUp()}>
        <div className="loyalty__pop-up-container">
          <h1 className="mb-3 loyalty-modal__title loyalty__pop-up-title">Уважаемые участники программы "Лето с Legrand"</h1>
          <p className="loyalty__pop-up-text">Обращаем ваше внимание на то, что в призовом фонде акции произошли изменения. В связи с высокой активностью
            по реализации купонов, были пересмотрены пороговые значения для заказа, а также добавлены дополнительные
            позиции. С изменениями можно ознакомиться в личном кабинете.</p>
        </div>
      </PopUp>

      <Modal isOpen={modalIsOpen} onClose={() => toggleModal(null)}>
        <div className="loyalty__loyalty-modal loyalty-modal pt-4 pb-4">
          {modalState === 'method' && <Method currentReceipt={currentReceipt} setModalState={setModalState}/>}
          {modalState === 'manual' && <Manual currentReceipt={currentReceipt} setModalState={setModalState}/>}
          {modalState === 'personalInfo' && <PersonalInfo setModalState={setModalState}/>}
          {modalState === 'check' && <Check setModalIsOpen={setModalIsOpen}/>}
          {modalState === 'promocode-registered' &&
            <PromocodeRegistered onClose={onClosePromocodeRegistered} promocode={promocode}/>}
          {modalState === 'prize-confirm' &&
            <PrizeConfirm setModalState={setModalState} prizeName={prizeName} prizeNumber={prizeNumber}
                          prizePoints={prizePoints} currentPoints={currentPoints}
                          setCurrentPoints={setCurrentPoints}/>}
          {modalState === 'prize-check' && <PrizeCheck setModalIsOpen={setModalIsOpen}/>}
        </div>
      </Modal>
      <div className="row mt-5 justify-content-between">
        <div className="col-12 col-lg-7">
          <h1 className="loyalty__title">Программа лояльности</h1>
          <p className="loyalty__desc">
            Покупай продукцию Legrand, копи баллы и выбирай ценные призы от Legrand!
          </p>
          <div className="loyalty__promo">
            <Input
              placeholder={"Введите промокод"}
              className="loyalty__promo-input"
              value={promocode}
              onChange={v => setPromocode(v.target.value)}
            />
            <Button
              value="Зарегистрировать"
              onClick={onRegisterPromocode}
              className="loyalty__promo-button"
              disabled={promocodeLoading}
            />
          </div>
          {promocodeError && (
            <div className="loyalty__promo-error">
              Промокод не действителен, проверьте корректность введенных данных
            </div>
          )}
        </div>
        <div className="col col-lg-5 col-xl-4">
          <article className="loyalty__info">
            <header className="loyalty__info__header">
              <img
                src="./images/loyalty/superelectric.svg"
                className="loyalty__info__img"
                alt="Суперэлектрик"
              />
              <h2 className="loyalty__info__title">
                Баллов накоплено
                <span className="loyalty__info__sum">{currentPoints}</span>
              </h2>
            </header>
            <p className="loyalty__info__desc--grey">
              Регистрируйте новые чеки чтобы заработать больше баллов и выбрать самые ценные призы
            </p>
          </article>
        </div>
      </div>
      <div className="row mt-4">
        <div className="col-12 col-lg-8">
          <h2 className="loyalty__subtitle">Зарегистрированные промокоды</h2>
          <div className="loyalty__table-wrap">
            <table className={'loyalty__table--checks'}>
              <thead>
              <tr>
                {/* @ts-ignore */}
                <th width="27%">№ промокода</th>
                {/* @ts-ignore */}
                <th width="31%">Дата регистрации</th>
                {/* @ts-ignore */}
                <th width="22%">Баллов</th>
                <th>Статус</th>
              </tr>
              </thead>
              <tbody>
              <RecieptList reciepts={uploadedReceipts}/>
              </tbody>
            </table>
          </div>
          {(totalPromocodes > promocodesPage * promocodesPerPage || loadingMorePromocodes) && (
            <button onClick={onLoadMorePromocodes} className={"loyalty__txt-btn"}
                    disabled={loadingMorePromocodes}>
              Показать еще
              <div className={'loyalty__txt-btn__icon'}/>
            </button>
          )}
        </div>
      </div>

      <div className="row mt-4">
        <div className="col-12">
          <h2 className="loyalty__subtitle">Витрина призов</h2>
          <div className="loyalty__showcase">
            <GiftList gifts={uploadedGifts}></GiftList>
            {/*{PRIZES.map(prize => (*/}
            {/*  <div key={prize.id}*/}
            {/*    className={"loyalty__showcase__item " + (currentPoints >= prize.price ? 'loyalty__showcase__item--avaliable ' : ' ') + (prize.enable == false ? 'loyalty__showcase__item--disorder ' : ' ')}>*/}
            {/*    <div className="loyalty__showcase__item--image">*/}
            {/*      <img src={`./images/loyalty-program/${prize.imageName}.png`} alt=""*/}
            {/*           className="promo-collection__img"/>*/}
            {/*    </div>*/}
            {/*    <h4>{prize.name}</h4>*/}
            {/*    <p>{prize.price} баллов</p>*/}

            {/*    <button onClick={() => toggleModalPrize(prize)}*/}
            {/*            className="loyalty__showcase__item--button">Выбрать*/}
            {/*    </button>*/}
            {/*    {!!prize.hint && (*/}
            {/*      <div className="loyalty__showcase__item--help">*/}
            {/*        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"*/}
            {/*             xmlns="http://www.w3.org/2000/svg">*/}
            {/*          <path fillRule="evenodd" clipRule="evenodd"*/}
            {/*                d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z"*/}
            {/*                fill="#E60012"/>*/}
            {/*        </svg>*/}
            {/*        <p dangerouslySetInnerHTML={{__html: prize.hint}}/>*/}
            {/*      </div>*/}
            {/*    )}*/}
            {/*  </div>*/}
            {/*))}*/}
          </div>
        </div>
      </div>
    </div>
  );
};

export default PageLayout(Loyalty);
