import styled from 'styled-components';

const Wrapper = styled.div`
  padding: 140px 90px 115px ;
  background: radial-gradient(16.26% 30.45% at 50% 50%, rgba(223, 242, 253, 0.2) 0%, rgba(223, 242, 253, 0) 100%), #F0F9FE;
  @media (max-width: 1024px) {
    padding: 50px 30px;
  }
`;
const Container = styled.div`
  max-width: 1440px;
  margin: 0 auto;
`;
const Title = styled.div`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  font-size: 60px;
  line-height: 70px;
  letter-spacing: 0.05em;
  max-width: 1080px;
  text-transform: uppercase;
  font-feature-settings: 'pnum' on, 'lnum' on;
  color: #475054;
  @media (max-width: 1024px) {
    font-size: 30px;
    line-height: 40px;
  }
`;
const Button = styled.div`
  background: #E60004;
  border-radius: 3px;
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 21px;
  text-align: center;
  color: #FFFFFF;
  margin-top: 55px;
  padding: 23px 57.5px;
  max-width: max-content;
`;

export default {
  Wrapper,
  Container,
  Title,
  Button,
};
