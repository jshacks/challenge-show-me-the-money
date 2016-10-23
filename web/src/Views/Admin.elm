module Views.Admin exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A
import Admin.Model exposing (..)
import Html.Events exposing (onClick, onInput)


view : String -> String -> State -> Html Msg
view submitOrgUrl token state =
    H.div []
        [ addOrganization submitOrgUrl token state
        , showOrganizations state
        ]


addOrganization : String -> String -> State -> Html Msg
addOrganization submitOrgUrl token { new } =
    H.section [ A.class "add-org-form form-s" ]
        [ H.h2 [] [ H.text "Add Organization" ]
        , H.input
            [ A.type' "text"
            , A.placeholder "Name"
            , A.value new.name
            , onInput (New << SetName)
            ]
            []
        , H.input
            [ A.type' "email"
            , A.placeholder "Email"
            , A.value new.email
            , onInput (New << SetEmail)
            ]
            []
        , H.input
            [ A.type' "text"
            , A.placeholder "identifier / CUI"
            , A.value new.identifier
            , onInput (New << SetIdentifier)
            ]
            []
        , H.div [ A.class "role" ]
            [ H.span [] [ H.text "Role:" ]
            , radio "Watcher" new.role Watcher
            , radio "Notifier" new.role Notifier
            ]
        , H.button
            [ A.class "submit"
            , onClick <| Register submitOrgUrl token
            ]
            [ H.text "Invite" ]
        ]


radio : String -> Role -> Role -> Html Msg
radio value selected toSelect =
    H.label []
        [ H.input
            [ A.type' "radio"
            , A.name "role"
            , onClick (New <| SetRole toSelect)
            , A.checked (selected == toSelect)
            ]
            []
        , H.text value
        ]


showOrganizations : State -> Html msg
showOrganizations { all } =
    H.section [ A.class "organizations-table" ]
        [ H.h2 [] [ H.text "Organizations" ]
        , H.table []
            [ H.thead []
                [ H.tr []
                    [ H.th [] [ H.text "Organization Name" ]
                    , H.th [] [ H.text "Identifier" ]
                    , H.th [] [ H.text "Email" ]
                    , H.th [] [ H.text "Role" ]
                    , H.th [] [ H.text "Status" ]
                    ]
                ]
            , H.tbody []
                (List.map orgRow all)
            ]
        ]


orgRow : Organization -> Html msg
orgRow { name, identifier, email, role } =
    H.tr []
        [ H.td [] [ H.text name ]
        , H.td [] [ H.text identifier ]
        , H.td [] [ H.text email ]
        , H.td [] [ H.text <| toString role ]
        , H.td [] [ H.text "Invited" ]
        ]
