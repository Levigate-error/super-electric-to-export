import * as React from 'react';
import Intro from './layouts/Intro';
import Production from './layouts/Production';
import Rules from './layouts/Rules';
import Prizes from './layouts/Prizes';
import Registration from './layouts/Registration';
import Questions from './layouts/Questions';
import PageLayout from '../../components/PageLayout';
import Navbar from './components/Navbar';
import {getData} from '../../utils/requests';
import eventBus from '../../utils/eventBus'

const Promo = () => {
  const [loggedIn, setLoggedIn] = React.useState<boolean>(false)
  const [addressesPdfLink, setAddressesPdfLink] = React.useState<string>('')

  React.useEffect(() => {
    getData({
      url: 'api/user/auth/check'
    }).then(res => {
      setLoggedIn(res?.data?.data?.auth || false)
    }).catch(() => {})
    getData({
      url: 'api/loyalty/documents'
    }).then(res => {
      setAddressesPdfLink(res?.data?.data?.document || '')
    }).catch(() => {})
  }, [])

  const onRegister = React.useCallback(() => {
    eventBus.dispatch('open-register')
  }, [eventBus])

  return (
    <div className="promo-new">
      <Navbar loggedIn={loggedIn} onRegister={onRegister} />
      <Intro />
      <Production addressesPdfLink={addressesPdfLink} />
      <Rules loggedIn={loggedIn} onRegister={onRegister} />
      <Prizes />
      <Registration loggedIn={loggedIn} onRegister={onRegister} />
      <Questions />
    </div>
  );
}
export default PageLayout(Promo);
