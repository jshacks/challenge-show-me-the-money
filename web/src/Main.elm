module Main exposing (..)

import Html exposing (Html, section, div, text)
import Html.App
import Html.Attributes as A
import Views.Auth as Auth
import Views.Playground as Playground
import Auth.LoginForm as LoginForm
import Admin.Model as Admin exposing (..)
import Routing
import Navigation
import Views.Admin as AdminView


type alias Model =
    { loginInfo : LoginForm.State
    , admin : Admin.State
    , route : Routing.Route
    }


type Msg
    = LoginMsg LoginForm.Msg
    | AdminMsg Admin.Msg


apiUrl : String
apiUrl =
    "http://77.81.165.2:8081/api/app.php"


loginUrl : String
loginUrl =
    apiUrl ++ "/authorize/login"


orgsUrl : String
orgsUrl =
    apiUrl ++ "/entities/"


main : Program Never
main =
    Navigation.program Routing.parser
        { init = init
        , view = view
        , update = update
        , urlUpdate = urlUpdate
        , subscriptions = \_ -> Sub.none
        }


init : Result String Routing.Route -> ( Model, Cmd Msg )
init result =
    let
        currentRoute =
            Routing.routeFromResult result

        model =
            initialModel currentRoute
    in
        ( model, initialCmd model )


token : String
token =
    "2146791811__1566c09849ff6aea3b5ace6ad4c200b0___12159bae365f5043ff4e735ad17d70d5e495d5a6"


initialModel : Routing.Route -> Model
initialModel route =
    --    { loginInfo = LoginForm.init
    { loginInfo = LoginForm.initCustom token (Just Admin)
    , route = route
    , admin = Admin.init
    }


initialCmd : Model -> Cmd Msg
initialCmd { loginInfo } =
    case loginInfo.role of
        Just Admin ->
            Admin.fetchOrgs AdminMsg orgsUrl loginInfo.token

        _ ->
            Cmd.none


urlUpdate : Result String Routing.Route -> Model -> ( Model, Cmd Msg )
urlUpdate result model =
    let
        currentRoute =
            Routing.routeFromResult result
    in
        ( { model | route = currentRoute }, Cmd.none )


update : Msg -> Model -> ( Model, Cmd Msg )
update msg model =
    case msg of
        LoginMsg loginMsg ->
            let
                ( loginInfo, loginCmd ) =
                    LoginForm.update loginMsg model.loginInfo
            in
                redirectAfterLogin <|
                    { model | loginInfo = loginInfo }
                        ! [ Cmd.map LoginMsg loginCmd ]

        AdminMsg adminMsg ->
            let
                ( admin, adminCmd ) =
                    Admin.update adminMsg model.admin
            in
                { model | admin = admin }
                    ! [ Cmd.map AdminMsg adminCmd ]


redirectAfterLogin : ( Model, Cmd Msg ) -> ( Model, Cmd Msg )
redirectAfterLogin ( model, cmd ) =
    if model.loginInfo.role == Nothing then
        ( model, cmd )
    else
        model ! [ Navigation.newUrl "#home", initialCmd model ]


view : Model -> Html Msg
view ({ route, loginInfo } as model) =
    let
        childView =
            case route of
                Routing.Login ->
                    loginView model

                Routing.Playground ->
                    Playground.view

                Routing.Home ->
                    case loginInfo.role of
                        Just Admin ->
                            adminView model

                        Just Watcher ->
                            watcherView model

                        Just Notifier ->
                            notifierView model

                        Nothing ->
                            unauthorized
    in
        Html.section [ A.class "main" ] [ childView ]


adminView : Model -> Html Msg
adminView { admin } =
    Html.App.map AdminMsg <| AdminView.view admin


watcherView : Model -> Html Msg
watcherView model =
    text "Watcher page"


notifierView : Model -> Html Msg
notifierView model =
    text "Notifier page"


loginView : Model -> Html Msg
loginView { loginInfo } =
    let
        loginView =
            Auth.loginForm loginUrl loginInfo
    in
        section [ A.class "main" ]
            [ Html.App.map LoginMsg loginView
            ]


unauthorized : Html Msg
unauthorized =
    text "You do not have access to this page"



{-
   Auth.loginForm ()
            Admin.addOrganization ()
          , Admin.showNotifiers
              ()
          , Admin.showWatchers ()
          ]
-}
