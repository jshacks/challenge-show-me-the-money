module Views.Admin exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A
import Admin.Model exposing (..)
import Html.Events exposing (onClick)


view : State -> Html Msg
view state =
    H.div []
        [ addOrganization state
        ]


addOrganization : State -> Html Msg
addOrganization { new } =
    H.section [ A.class "add-org-form form-s" ]
        [ H.h2 [] [ H.text "Add watcher or notifier" ]
        , H.input
            [ A.type' "text"
            , A.placeholder "Name"
            , A.value new.name
            ]
            []
        , H.input
            [ A.type' "text"
            , A.placeholder "identifier / CUI"
            , A.value new.identifier
            ]
            []
        , H.input
            [ A.type' "email"
            , A.placeholder "Email"
            , A.value new.email
            ]
            []
        , H.div [ A.class "role" ]
            [ H.span [] [ H.text "Role:" ]
            , radio "Watcher" new.role Watcher
            , radio "Notifier" new.role Notifier
            ]
        , H.button [ A.class "submit" ] [ H.text "Submit" ]
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


showNotifiers : Html msg
showNotifiers =
    H.section [ A.class "organizations-table" ]
        [ H.h2 [] [ H.text "Notifiers" ]
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
                [ H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                , H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                ]
            ]
        ]


showWatchers : Html msg
showWatchers =
    H.section [ A.class "organizations-table" ]
        [ H.h2 [] [ H.text "Watchers" ]
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
                [ H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                , H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy identifier" ]
                    , H.td [] [ H.text "dummy email" ]
                    , H.td [] [ H.text "Watcher or Notifier" ]
                    , H.td [] [ H.text "Invited or Joined" ]
                    ]
                ]
            ]
        ]
