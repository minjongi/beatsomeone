Beat Someone
============

씨아이보드 기반의 음악 거래 사이트

## 실행방법

* 라이브러리 설치 : npm i
* 개발 : npm run dev
* 빌드 : npm run build

## 씨아이보드 설치시 유의사항
* 테이블 Prefix는 CB로 고정
* Layout은 일반으로 사용

## DB 작업
* SKIN 추가
    *     insert into cb_config values ('layout_beatsomeone','beatsomeone_basic');
    *     insert into cb_config values ('mobile_layout_beatsomeone','beatsomeone_mobile');
    
* 연관음반 테이블 추가
    *       create table cb_cmall_item_relation
            (
                cir_id   int auto_increment
                    primary key,
                cit_id   int null,
                cit_id_r int null
            )
                comment '컨텐츠몰 관련상품';

* 멤버타입 (일반 : 1 / 뮤지션 : 2) 컬럼 추가
    *     alter table cb_member ADD mem_usertype int DEFAULT 1;
    
* 멤버 그룹 추가
    *     delete from cb_member_group where cb_member_group.mgr_id > 1;
    *     insert into cb_member_group(mgr_id,mgr_title,mgr_is_default,mgr_datetime,mgr_order,mgr_description) values (2,'뮤지션그룹',0,now(),2,'');

## 환경설정
* 뮤지션 회원 추가정보 (계좌)
    * 환경설정 - 회원가입설정 - 가입폼 관리 (추가)
        * mem_musician_bank
            * 은행
          	* 단일선택(select)
          	    *     국민
                      신한
          		      우리
          		      농협
          		      카카오뱅크
                      케이뱅크
                      
        * mem_musician_account
            * 계좌번호
            * 한줄입력형식
            
        * mem_musician_account_nm
            * 예금주
            * 한줄입력형식
            
      
## 설정파일
* /vue.config.js
    * vuecli webpack 환경설정
    * 페이지 추가될 경우 configureWebpack 의 entry 에 추가
    
* /package.json
    * eslintConfig 에 eslint 변경사항 적용
    
