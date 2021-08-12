﻿using System;

namespace NETCoreProject.Models
{
    public interface IEntity
    {
        public int Id { get; set; }

        public DateTime? CreatedAt { get; set; }
        public DateTime? UpdatedAt { get; set; }
        public DateTime? DeletedAt { get; set; }
    }
}
