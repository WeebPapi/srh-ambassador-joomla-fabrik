# ER Model

```mermaid
erDiagram
  AMBASSADOR {
    int id PK
    string name
    string photo
    string bio
    string contact_preference
    string availability
    string status
  }
  PROGRAM {
    int id PK
    string program_name
    string degree_level
    string department
    text description
  }
  COUNTRY_REGION {
    int id PK
    string name
  }
  LANGUAGE {
    int id PK
    string name
    string iso_code
  }
  EVENT {
    int id PK
    string title
    datetime starts_at
    string location_or_link
    text description
    string event_type
    int club_id FK
    int interested_count
  }
  CLUB_POLL {
    int id PK
    string title
    string club_idea
    int interest_count
    int popularity_threshold
    string status
  }
  CLUB {
    int id PK
    string name
    text description
    string category
    string status
    int member_count
  }
  CLUB_MEMBER {
    int club_id FK
    int user_id FK
    string role
  }
  STUDENT_INQUIRY {
    int id PK
    string student_name
    string email
    string country
    text message
    string status
  }
  FAQ {
    int id PK
    string title
    text body
    bool published
  }
  FAQ_CATEGORY {
    int id PK
    string name
    text description
  }

  AMBASSADOR }o--o{ PROGRAM : joins
  AMBASSADOR }o--o{ COUNTRY_REGION : represents
  AMBASSADOR }o--o{ LANGUAGE : speaks
  EVENT }o--o{ AMBASSADOR : assigned
  CLUB ||--o{ EVENT : hosts
  CLUB_POLL }o--o| CLUB : converted_to
  AMBASSADOR ||--o{ CLUB_POLL : creates
  AMBASSADOR ||--o{ CLUB : creates
  CLUB ||--o{ CLUB_MEMBER : has
  STUDENT_INQUIRY }o--|| PROGRAM : interested_in
  STUDENT_INQUIRY }o--o| AMBASSADOR : assigned_to
  STUDENT_INQUIRY }o--o| LANGUAGE : preferred_language
  FAQ }o--|| FAQ_CATEGORY : categorized_as
  FAQ }o--|| LANGUAGE : written_in
```

## Entities And Fields

- Ambassador: name, photo, degree program display field, countries/regions, languages, bio, contact preference, availability, status.
- Program: program name, degree level, department, description, related ambassadors.
- Country/Region: name, related languages, related ambassadors.
- Language: name, ISO code, related ambassadors.
- Event: title, date/time, location or online link, description, assigned ambassadors, optional club, event type, interested count.
- Club Poll: title, club idea, description, interest count, popularity threshold, status, creating ambassador.
- Club: name, description, category, status, member count, source poll, creating ambassador, members, events.
- Student Inquiry: student name, email, country, interested program, question/message, preferred language, assigned ambassador, status.
- FAQ: title, category, body/content, language, published status.
- FAQ Category: name, description, related FAQs.
